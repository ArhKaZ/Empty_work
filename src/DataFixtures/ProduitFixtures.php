<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\CollectionArticle;
use App\Entity\Fournisseur;
use App\Entity\MatierePremiere;
use App\Entity\Produit;
use App\Entity\Taille;
use App\Entity\UtiliseMP;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adresseFour = new Adresse();
        $adresseFour
            ->setAdresse("20 rue de test")
            ->setVille("Annecy")
            ->setCodePostal("74000")
            ->setPays("France")
        ;
        $fournisseur = new Fournisseur();
        $fournisseur
            ->setNum(01)
            ->setNom("Tex")
            ->setActivite("Grossiste")
            ->setTel("0400000000")
            ->setType("fabricant_founisseur")
            ->setDateCreation(new \DateTime())
            ->setAdresse($adresseFour)
        ;
        $mpTissu = new MatierePremiere();
        $mpTissu
            ->setType("tissu")
            ->setRef("COTON")
            ->setFournisseur($fournisseur)
            ->setUniteMesure("METRE")
            ->setPrixHt(0.1)
            ->setSeuilAlerte(20)
            ->setSeuilCritique(10)
        ;
        $mpNoeud = new MatierePremiere();
        $mpNoeud
            ->setType("noeud")
            ->setRef("NOEUD BLANC")
            ->setFournisseur($fournisseur)
            ->setUniteMesure("UNITE")
            ->setPrixHt(0.2)
            ->setSeuilAlerte(20)
            ->setSeuilCritique(10)
        ;
        $mpFour1 = new MatierePremiere();
        $mpFour1
            ->setType("fourniture")
            ->setRef("FIL")
            ->setFournisseur($fournisseur)
            ->setUniteMesure("METRE")
            ->setPrixHt(0.01)
            ->setSeuilAlerte(20)
            ->setSeuilCritique(10)
        ;
        $mpFour2 = new MatierePremiere();
        $mpFour2
            ->setType("fourniture")
            ->setRef("ELASTIQUE")
            ->setFournisseur($fournisseur)
            ->setUniteMesure("METRE")
            ->setPrixHt(0.01)
            ->setSeuilAlerte(20)
            ->setSeuilCritique(10)
        ;

        $article = new Article();
        $article
            ->setNom("TSHIRT")
            ->setRefCompta("000001")
            ->setNbNoeud(1)
        ;

        $collection = new CollectionArticle();
        $collection
            ->setNom("COLLECTION TEST")
            ->setMotifFilename("carre-lolita-60942ac499f19.jpg")
            ->setCouleurNoeud($mpNoeud)
            ->setTissu($mpTissu)
        ;

        $tailles = [
            ["XS", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
            ["S", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
            ["M", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
            ["L", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
            ["XL", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
            ["XXL", 1, [[$mpFour1, 1], [$mpFour2, 2]]],
        ];

        $refCompta = 1000;
        foreach ($tailles as $arrayTaille) {

            $taille = new Taille();
            $taille
                ->setNom($arrayTaille[0])
                ->setQuantiteTissu($arrayTaille[1])
            ;
            foreach ($arrayTaille[2] as $arrayUseMp) {
                $useMp = new UtiliseMP();
                $useMp
                    ->setMatierePremiere($arrayUseMp[0])
                    ->setQuantitee($arrayUseMp[1])
                ;
                $taille->addUtiliseMP($useMp);
            }
            $article->addTaille($taille);
            $collection->addTaille($taille);

            $refCompta++;
            $produit = new Produit();
            $produit
                ->setCollection($collection)
                ->setTaille($taille)
                ->setDansCatalogue(true)
                ->setPrixPublic("10")
                ->setPrixRevendeur("8")
                ->setRefCompta($refCompta)
                ->setSeuilAlerte(20)
                ->setSeuilCritique(10)
                ->setRef(
                    substr($collection, 0, 3) .
                    substr($taille->getArticle(), 0, 3) .
                    $taille
                )
            ;
            $manager->persist($produit);
        }

        $manager->flush();
    }
}
