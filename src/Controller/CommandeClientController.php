<?php

namespace App\Controller;

use App\Data\ExportVente;
use App\Entity\CommandeClient;
use App\Form\CommandeClientType;
use App\Form\ExportVenteType;
use App\Form\ImportVenteType;
use App\Repository\CommandeClientRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
/**
 * @Route("/commande_client")
 */
class CommandeClientController extends AbstractController
{
    /**
     * @Route("/", name="commande_client_index", methods={"GET","POST"})
     */
    public function index(CommandeClientRepository $commandeClientRepository, Request $request): Response
    {
        $exportVente = new ExportVente();
        $exportVente->month = new \DateTime(date('Y-m-01'));
        $form = $this->createForm(ExportVenteType::class, $exportVente);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            return $this->redirectToRoute('vente_excel', [
                'month' => $exportVente->month->format('Y-m')
            ]);
        }
        return $this->render('commande_client/index.html.twig', [
            'commande_clients' => $commandeClientRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="commande_client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeClient = new CommandeClient();
        $form = $this->createForm(CommandeClientType::class, $commandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeClient);
            $entityManager->flush();

            return $this->redirectToRoute('commande_client_index');
        }

        return $this->render('commande_client/new.html.twig', [
            'commande_client' => $commandeClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="commande_client_show", methods={"GET"})
     */
    public function show(CommandeClient $commandeClient): Response
    {
        return $this->render('commande_client/show.html.twig', [
            'commande_client' => $commandeClient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeClient $commandeClient): Response
    {
        $form = $this->createForm(CommandeClientType::class, $commandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_client_index');
        }

        return $this->render('commande_client/edit.html.twig', [
            'commande_client' => $commandeClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeClient $commandeClient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeClient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_client_index');
    }

    /**
     * @Route("/export-{month}", name="vente_excel", methods={"GET", "POST"})
     * @param CommandeClientRepository $commandeClientRepository
     * @return Response
     * @throws Exception
     */
    public function excelgen(CommandeClientRepository $commandeClientRepository, $month): Response
    {
        $datemoisder = new \DateTime($month.'-01');
        /*$mois = date("m");
        $day = date("d");
        $annee = date("Y");
        $datemoisder->setDate($mois, $day, $annee);*/
        $spreadsheet = new Spreadsheet();
        $commandeC = $commandeClientRepository->getVenteMoisDer($datemoisder);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "Facture");
        $sheet->setCellValue("B1", "Date Commande");
        $sheet->setCellValue("C1", "Client");
        $sheet->setCellValue("D1", "Date Livraison");
        $sheet->setCellValue("E1", "Produit");
        $sheet->setCellValue("F1", "Taille");
        $sheet->setCellValue("G1", "Collection");
        $sheet->setCellValue("H1", "Montant");
        $sheet->setCellValue("I1", "Frais de livraison");
        $sheet->setCellValue("J1", "Type paiement");
        $sheet->setCellValue("K1", "Référence compta");
        $numcell = 2;
        foreach ($commandeC as $i) {
            $panier = $i->getPanier();
            foreach ($panier as $item) {
                $cell = "A" . $numcell;
                $vari = $i->getFacture();
                $sheet->setCellValue($cell, $datemoisder);

                $cell = "B" . $numcell;
                $vari = $i->getDateCommande();
                $sheet->setCellValue($cell, $vari);

                $cell = "C" . $numcell;
                $vari = $i->getClient();
                $sheet->setCellValue($cell, $vari);

                $cell = "D" . $numcell;
                $vari = $i->getDateLivraison();
                $sheet->setCellValue($cell, $vari);

                $cell = "E" . $numcell;
                $vari = $item->getProduit();
                $sheet->setCellValue($cell, $vari);

                $cell = "F" . $numcell;
                $vari = $item->getProduit()->getTaille();
                $sheet->setCellValue($cell, $vari);

                $cell = "G" . $numcell;
                $vari = $item->getProduit()->getCollection();
                $sheet->setCellValue($cell, $vari);

                $cell = "H" . $numcell;
                $vari = $i->getMontant();
                $sheet->setCellValue($cell, $vari);

                $cell = "I" . $numcell;
                $vari = $i->getFraisLivraison();
                $sheet->setCellValue($cell, $vari);

                $cell = "J" . $numcell;
                $vari = $i->getTypePaiement();
                $sheet->setCellValue($cell, $vari);

                $cell = "K" . $numcell;
                $vari = $item->getProduit()->getRefCompta();
                $sheet->setCellValue($cell, $vari);
                $numcell = $numcell + 1;
            }
        }

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'ventes-'.$month.'.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/import", name="import")
     * @return Response
     */
    public function import(Request $request): Response
    {
        $form = $this->createForm(ImportVenteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'oui');
        }

        return $this->render('commande_client/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
