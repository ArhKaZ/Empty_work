<?php

namespace App\Form\DataTransformer;

use App\Entity\Client;
use App\Entity\Taille;
use App\Repository\ClientRepository;
use App\Repository\TailleRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class ClientTransformer implements DataTransformerInterface
{
    private $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform($client): string
    {
        if ($client) return $client->getNom() .' '. $client->getPrenom();
        else return '';
    }

    public function reverseTransform($clientName): ?Client
    {
        $sep = strpos($clientName, ' ');
        $nom = substr($clientName, 0, $sep);
        $prenom = substr($clientName, $sep+1);
        return $this->repository->findOneBy([
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }
}