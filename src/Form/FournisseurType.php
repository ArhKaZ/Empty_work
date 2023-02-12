<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num')
            ->add('nom')
            ->add('activite')
            ->add('tel', TelType::class)
            ->add('portable', TelType::class, ['required' => false])
            ->add('fax', TelType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('site', UrlType::class, ['required' => false])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'fabricant' => 'fabricant',
                    'founisseur' => 'founisseur',
                    'fabricant et founisseur' => 'fabricant_founisseur',
                ]
            ])
            ->add('date_creation', null, [
                'widget' => 'single_text',
                'label_attr' => ['class' => 'col-sm-4'],
                'label' => 'Date',
            ])
            ->add('adresse', AdresseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
