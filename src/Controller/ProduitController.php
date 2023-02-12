<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CollectionArticle;
use App\Entity\Produit;
use App\Entity\StockProduit;
use App\Form\ProduitType;
use App\Form\SearchProduitType;
use App\Form\StockProduitType;
use App\Repository\ProduitRepository;
use App\Repository\StockProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use App\Data\SearchProduit;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $repository, Request $request): Response
    {
        if ($request->cookies->get('filter')) {
            $filter = SearchProduit::create($request->cookies->get('filter'));
            $filter->collections = $this->em->getRepository(CollectionArticle::class)->findBy(['id' => $filter->collections]);
            $filter->articles = $this->em->getRepository(Article::class)->findBy(['id' => $filter->articles]);
	    $filter->page = 1;
        } else $filter = new SearchProduit();


        if ($request->get('page')) {
            $filter->page = $request->get('page');
        }

        $form = $this->createForm(SearchProduitType::class, $filter);
        $form->handleRequest($request);

        $filter = $form->getData();

        if ($form->isSubmitted()) $filter->page = 1;

        $produits = $repository->findSearch($filter);

        $res = $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView(),
        ]);
        $res->headers->setCookie(new Cookie('filter', $filter));

        return $res;
    }

    /**
     * @Route("/id<d+>", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/stock", name="produit_stock_index", methods={"GET"})
     */
    public function stock(StockProduitRepository $repository, Produit $produit): Response
    {
        return $this->render('stock_produit/index.html.twig', [
            'stock_produits' => $repository->findBy(['produit' => $produit], ['date' => 'DESC']),
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/stock/update", name="produit_stock_update", methods={"GET","POST"})
     */
    public function updateStock(Request $request, Produit $produit): Response
    {
        $stockProduit = new StockProduit();
        $stockProduit
            ->setDate(new \DateTime())
            ->setProduit($produit)
            ->setOrigine("Modification manuelle");
        $form = $this->createForm(StockProduitType::class, $stockProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockProduit->appli();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_stock_index', ['id' => $produit->getId()]);
        }

        return $this->render('stock_produit/new.html.twig', [
            'stock' => $stockProduit,
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{idProduit}/stock/{id}", name="produit_stock_delete", methods={"DELETE"})
     */
    public function deleteStock(Request $request, Produit $produit, StockProduit $stockProduit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockProduit->getId(), $request->request->get('_token'))) {
            // TODO: Géréer l'annulation d'une action du stock

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_stock_index');
    }

    /**
     * @Route("/exportProd", name="prod_excel", methods={"GET", "POST"})
     * @param ProduitRepository $produitRepository
     * @return Response
     */
  public function  excelgenpro(ProduitRepository $produitRepository) : Response
  {
      $spreadsheet = new Spreadsheet();
      $produits = $produitRepository->findAll(); //TODO : a changer selon la demande de caroline
      $sheet = $spreadsheet->getActiveSheet();


      $sheet->setCellValue("A1", "Référence Compta");
      $sheet->setCellValue("B1", "Taille");
      $sheet->setCellValue("C1", "Stock");
      $numofitem = 2;
      foreach ($produits as $item)
      {
          $cell = "A" . $numofitem;
          $vari = $item->getArticle()->getRefCompta();
          $sheet->setCellValue($cell, $vari);

          $cell = "B" . $numofitem;
          $vari = $item->getTaille();
          $sheet->setCellValue($cell, $vari);

          $cell = "C". $numofitem;
          $vari = $item->getStock();
          $sheet->setCellValue($cell, $vari);
          $numofitem = $numofitem + 1;
      }
      $writer = new Xlsx($spreadsheet);
      $ajd = mktime(0,0,0, date("m"), date("d"), date("Y"));
      $ajd = date("d.m.y");
      $fileName = 'StocksProduits_' . $ajd .".xlsx";
      $temp_file = tempnam(sys_get_temp_dir(), $fileName);
      $writer->save($temp_file);
      return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

  }

}
