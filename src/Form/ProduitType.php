<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mb = ['attr' => ['class' => 'mb-3']];
        $builder
            ->add('ref', null, $mb)
            ->add('refCompta', TextType::class, [
                'attr' => ['class' => 'mb-3'],
                'mapped' => false,
                'required' => false,
            ])
            ->add('seuil_alerte', null, [
                'attr' => ['class' => 'mb-3'],
            ])
            ->add('seuil_critique', null, [
                'attr' => ['class' => 'mb-3'],
            ])
            ->add('prix_public', MoneyType::class, $mb)
            ->add('prix_revendeur', MoneyType::class, $mb)
            /*->add('stock')*/
            ->add('dans_catalogue', null, [
                'required' => false,
                'attr' => ['class' => 'mb-3'],
            ])
            /*->add('collection')*/
            /*->add('taille')*/
            /*->add('utiliseMPs', CollectionType::class, [
                'entry_type' => UtiliseMPType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Matières premières',
                'attr' => ['class' => 'mb-3'],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
