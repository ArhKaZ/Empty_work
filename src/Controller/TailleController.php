<?php

namespace App\Controller;

use App\Entity\Taille;
use App\Form\TailleType;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/taille")
 */
class TailleController extends AbstractController
{
    /**
     * @Route("/", name="taille_index", methods={"GET"})
     */
    public function index(TailleRepository $tailleRepository): Response
    {
        return $this->render('taille/index.html.twig', [
            'tailles' => $tailleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="taille_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taille = new Taille();
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taille);
            $entityManager->flush();

            return $this->redirectToRoute('taille_index');
        }

        return $this->render('taille/new.html.twig', [
            'taille' => $taille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taille_show", methods={"GET"})
     */
    public function show(Taille $taille): Response
    {
        return $this->render('taille/show.html.twig', [
            'taille' => $taille,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="taille_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Taille $taille): Response
    {
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taille_index');
        }

        return $this->render('taille/edit.html.twig', [
            'taille' => $taille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taille_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Taille $taille): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('taille_index');
    }
}
