<?php

namespace App\Form;

use App\Entity\MatierePremiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatierePremiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref')
            ->add('unite_mesure', ChoiceType::class, [
                'label' => 'Vente',
                'choices' => [
                    'à l\'unité' => 'UNITE',
                    'au mètre' => 'METRE',
                ]
            ])
            /*->add('stock')*/
            ->add('seuil_alerte')
            ->add('seuil_critique')
            ->add('prix_ht', MoneyType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'fourniture' => 'fourniture',
                    'tissu' => 'tissu',
                    'noeud' => 'noeud'
                ]
            ])
            ->add('fournisseur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatierePremiere::class,
        ]);
    }
}
