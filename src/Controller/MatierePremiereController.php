<?php

namespace App\Controller;

use App\Entity\MatierePremiere;
use App\Entity\StockMP;
use App\Form\MatierePremiereType;
use App\Form\StockMPType;
use App\Repository\MatierePremiereRepository;
use App\Repository\StockMPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matiere_premiere")
 */
class MatierePremiereController extends AbstractController
{
    /**
     * @Route("/", name="matiere_premiere_index", methods={"GET"})
     */
    public function index(MatierePremiereRepository $repository): Response
    {
        return $this->render('matiere_premiere/index.html.twig', [
            'matiere_premieres' => $repository->findBy([],['type' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="matiere_premiere_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $matierePremiere = new MatierePremiere();
        $matierePremiere
            ->setStockMarjoris(0)
            ->setStockSobele(0)
            ->setSeuilAlerte(20)
            ->setSeuilCritique(10);
        $form = $this->createForm(MatierePremiereType::class, $matierePremiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matierePremiere);
            $entityManager->flush();

            return $this->redirectToRoute('matiere_premiere_index');
        }

        return $this->render('matiere_premiere/new.html.twig', [
            'matiere_premiere' => $matierePremiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matiere_premiere_show", methods={"GET"})
     */
    public function show(MatierePremiere $matierePremiere): Response
    {
        return $this->render('matiere_premiere/show.html.twig', [
            'matiere_premiere' => $matierePremiere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="matiere_premiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MatierePremiere $matierePremiere): Response
    {
        $form = $this->createForm(MatierePremiereType::class, $matierePremiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matiere_premiere_index');
        }

        return $this->render('matiere_premiere/edit.html.twig', [
            'matiere_premiere' => $matierePremiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matiere_premiere_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MatierePremiere $matierePremiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matierePremiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matierePremiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('matiere_premiere_index');
    }

    /**
     * @Route("/{id}/stock", name="matiere_premiere_stock_index", methods={"GET"})
     */
    public function stock(StockMPRepository $repository, MatierePremiere $matierePremiere): Response
    {
        return $this->render('stock_mp/index.html.twig', [
            'stock_mps_1' => $repository->findBy(['matiere_premiere' => $matierePremiere, 'lieu' => 'SOBELE'],['date' => 'DESC']),
            'stock_mps_2' => $repository->findBy(['matiere_premiere' => $matierePremiere, 'lieu' => 'MARJORIS'],['date' => 'DESC']),
            'matiere_premiere' => $matierePremiere,
        ]);
    }

    /**
     * @Route("/{id}/stock/update/{lieu}", name="matiere_premiere_stock_update", methods={"GET","POST"})
     */
    public function updateStock(Request $request, MatierePremiere $matierePremiere, $lieu): Response
    {
        $stockMP = new StockMP();
        $stockMP
            ->setLieu($lieu)
            ->setDate(new \DateTime())
            ->setMatierePremiere($matierePremiere)
            ->setOrigine("Modification manuelle");
        $form = $this->createForm(StockMPType::class, $stockMP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockMP->appli();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matierePremiere);
            $entityManager->flush();

            return $this->redirectToRoute('matiere_premiere_stock_index', ['id' => $matierePremiere->getId()]);
        }

        switch ($lieu) {
            case 'MARJORIS':
                $oldStock = $matierePremiere->getStockMarjoris();
                break;
            case 'SOBELE':
                $oldStock = $matierePremiere->getStockSobele();
                break;
        }

        return $this->render('stock_mp/new.html.twig', [
            'stock_mp' => $stockMP,
            'matiere_premiere' => $matierePremiere,
            'form' => $form->createView(),
            'oldStock' => $oldStock,
        ]);
    }

    /**
     * @Route("{idProduit}/stock/{id}", name="matiere_premiere_stock_delete", methods={"DELETE"})
     */
    public function deleteStock(Request $request, MatierePremiere $matierePremiere, StockMP $stockMP): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stockMP->getId(), $request->request->get('_token'))) {
            // TODO: Géréer l'annulation d'une action du stock

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockMP);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_stock_index');
    }

}
