<?php


namespace App\DataFixtures;


use App\Entity\Adresse;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use League\Csv\Statement;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adresse = new Adresse();
        $adresse
            ->setAdresse("1 rue de test")
            ->setCodePostal("74000")
            ->setPays("France")
            ->setVille("Annecy");
        $client = new Client();
        $client
            ->setNom("DEFRESNE")
            ->setPrenom("Dimitri")
            ->setTelephone("0600000000")
            ->setMail("dimitri.defresne@gmail.com")
            ->setAdresse($adresse);
        $manager->persist($client);

        $adresse = new Adresse();
        $adresse
            ->setAdresse("2 rue de test")
            ->setCodePostal("74000")
            ->setPays("France")
            ->setVille("Annecy");
        $client = new Client();
        $client
            ->setNom("PLANTEVNI")
            ->setPrenom("Thomas")
            ->setTelephone("0700000000")
            ->setMail("thomas.plantevin@gmail.com")
            ->setAdresse($adresse);
        $manager->persist($client);

        $manager->flush();
    }
}