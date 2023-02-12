<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CollectionArticle;
use App\Entity\Produit;
use App\Form\CollectionArticleType;
use App\Repository\CollectionArticleRepository;
use App\Repository\MatierePremiereRepository;
use App\Service\UploaderHealper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection")
 */
class CollectionArticleController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="collection_index", methods={"GET"})
     */
    public function index(CollectionArticleRepository $repository): Response
    {
        return $this->render('collection_article/index.html.twig', [
            'collections' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collection_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHealper $uploaderHealper): Response
    {
        $collection = new CollectionArticle();
        $form = $this->createForm(CollectionArticleType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['motifFile']->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHealper->uploadMotifCollection($uploadedFile);
                $collection->setMotifFilename($newFilename);
            }

            $this->em->persist($collection);
            $this->em->flush();

            $this->addFlash('success', 'La collection a bien été créée');

            $dansCatalog = $form['addToCatalog']->getData();
            foreach ($collection->getTailles() as $taille) {
                $produit = new Produit();
                $produit
                    ->setCollection($collection)
                    ->setTaille($taille)
                    ->setDansCatalogue($dansCatalog)
                    ->setPrixPublic(0)
                    ->setPrixRevendeur(0)
                    ->setSeuilAlerte(20)
                    ->setSeuilCritique(10)
                    ->setRef(
                        substr($collection, 0, 3) .
                        substr($taille->getArticle(), 0, 3) .
                        $taille
                    );
                $this->em->persist($produit);
            }
            $this->em->flush();

            return $this->redirectToRoute('collection_index');
        }

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('collection_article/new.html.twig', [
            'collection' => $collection,
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_show", methods={"GET"})
     */
    public function show(CollectionArticle $collectionArticle): Response
    {
        return $this->render('collection_article/show.html.twig', [
            'collection_article' => $collectionArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CollectionArticle $collection
     * @param $uploaderHealper
     * @return Response
     */
    public function edit(Request $request, CollectionArticle $collection, UploaderHealper $uploaderHealper): Response
    {
        $oldTaillesId = [];
        foreach ($collection->getTailles() as $taille) {
            $oldTaillesId[] = $taille->getId();
        }

        $form = $this->createForm(CollectionArticleType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['motifFile']->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHealper->uploadMotifCollection($uploadedFile);
                $collection->setMotifFilename($newFilename);
            }

            $dansCatalog = $form['addToCatalog']->getData();
            foreach ($collection->getTailles() as $taille) {
                if (!in_array($taille->getId(), $oldTaillesId)) {
                    $produit = new Produit();
                    $produit
                        ->setCollection($collection)
                        ->setTaille($taille)
                        ->setDansCatalogue($dansCatalog)
                        ->setPrixPublic(0)
                        ->setPrixRevendeur(0)
                        ->setSeuilAlerte(20)
                        ->setSeuilCritique(10)
                        ->setRef(
                            substr($collection, 0, 3) .
                            substr($taille->getArticle(), 0, 3) .
                            substr($taille, 0, 3)
                        );
                    $this->em->persist($produit);
                }
            }
            $this->em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collection);
            $entityManager->flush();

            return $this->redirectToRoute('collection_index');
        }

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('collection_article/new.html.twig', [
            'collection' => $collection,
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CollectionArticle $collection): Response
    {
        if ($this->isCsrfTokenValid('delete' . $collection->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($collection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_index');
    }


}
