<?php

namespace App\Form;

use App\Entity\CCProduit;
use App\Entity\MatierePremiere;
use App\Entity\Produit;
use App\Entity\UtiliseMP;
use App\Repository\MatierePremiereRepository;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('produit')*/
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'query_builder' => function (ProduitRepository $repository) {
                    return $repository->getQueryDansCatalogue();
                },
                'choice_label' => function (Produit $produit) {
                    return $produit->getRef() . ' - ' . $produit->getPrixPublic() . ' €';
                },
                'choice_value' => function (?Produit $produit) {
                    return $produit ? $produit->getId() . '_' . $produit->getPrixPublic() : '';
                },
                'attr' => [
                    'class' => 'produits',
                    'onChange' => 'updatePrix();'
                ],
            ])
            ->add('quantite', IntegerType::class, [
                'data' => 1,
                'attr' => [
                    'min' => 1,
                    'class' => 'qte',
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CCProduit::class,
        ]);
    }
}
