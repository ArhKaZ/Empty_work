<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CollectionArticle;
use App\Entity\MatierePremiere;
use App\Entity\Produit;
use App\Entity\Taille;
use App\Entity\UtiliseMP;
use App\Form\ArticleType;
use App\Form\TailleType;
use App\Repository\ArticleRepository;
use App\Repository\MatierePremiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a été créé avec succès");

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->remove('tailles');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'article a été modifié avec succès");

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {


        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a été supprimer avec succès");
        }

        return $this->redirectToRoute('article_index');

    }

    /**
     * @Route("/{id_article}/{id}", name="article_taille_edit", methods={"GET","POST"})
     */
    public function editTaille(Request $request, Taille $taille, MatierePremiereRepository $repository): Response
    {
        if (!$taille->getMpDef()) {
            $fournitures = $repository->findFourniture();
            foreach ($fournitures as $fourniture) {
                $useMP = new UtiliseMP();
                $useMP
                    ->setTaille($taille)
                    ->setMatierePremiere($fourniture);
                $taille->addUtiliseMP($useMP);
            }
        }

        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "La taille a été modifié avec succès");

            return $this->redirectToRoute('article_index');
        }

        return $this->render('taille/edit.html.twig', [
            'taille' => $taille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id_article}/{id}", name="article_taille_delete", methods={"DELETE"})
     */
    public function deleteTaille(Request $request, Taille $taille): Response

    {
        if ($this->isCsrfTokenValid('delete' . $taille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taille);
            $entityManager->flush();

            $this->addFlash('success', "La taille a été supprimer avec succès");
        }

        return $this->redirectToRoute('article_index');
    }
}
