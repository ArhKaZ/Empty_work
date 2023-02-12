<?php

namespace App\Form;

use App\Entity\StockProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mb = ['attr' => ['class' => 'mb-3']];
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-3'],
            ])
            ->add('quantitee', null, $mb)
            ->add('commentaire', null, $mb)
            /*->add('origine')*/
            /*->add('produit')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockProduit::class,
        ]);
    }
}
