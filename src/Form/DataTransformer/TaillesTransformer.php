<?php

namespace App\Form\DataTransformer;

use App\Entity\Taille;
use App\Repository\TailleRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class TaillesTransformer implements DataTransformerInterface
{
    private $repository;

    public function __construct(TailleRepository $repository)
    {
        $this->repository = $repository;
    }


    public function transform($value): string
    {
        return implode(',',$value);
    }

    public function reverseTransform($string): array
    {
        if (null === $string || u($string)->isEmpty()) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', u($string)->split(','))));

        $tailles = [];
        foreach ($names as $name) {
            $taille = new Taille();
            $taille->setNom($name);
            $tailles[] = $taille;
        }

        return $tailles;
    }
}