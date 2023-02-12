<?php

namespace App\Form;

use App\Entity\CommandeClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \App\Form\Type\ClientType;

class CommandeClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num')
            ->add('commentaire')
            ->add('date_commande', null, [
                'widget' => 'single_text',
            ])
            ->add('date_livraison', null, [
                'widget' => 'single_text',
            ])
            ->add('facture')
            ->add('bon_livraison')
            ->add('frais_livraison', MoneyType::class, [
                'required' => false,
            ])
            ->add('type_paiement', ChoiceType::class, [
                'choices' => [
                    'CB' => 'CB',
                    'ESPECES' => 'ESPECES',
                    'CHEQUE' => 'CHEQUE',
                    'CHEQUE CADEAU' => 'CHEQUE CADEAU',
                    'VIREMENT' => 'VIREMENT',
                ]
            ])
            ->add('lieu_vente', ChoiceType::class, [
                'choices' => [
                    'SITE' => 'SITE',
                    'BOUTIQUE' => 'BOUTIQUE',
                ]
            ])
            ->add('avoir_num')
            ->add('avoir_montant')
            ->add('client', ClientType::class, [
                'row_attr' => ['class' => 'autocomplete'],
                'required' => true,
            ])
            ->add('panier', CollectionType::class, [
                'entry_type' => PanierType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Produits',
                'attr' => ['class' => 'mb-3'],
            ])
            ->add('ttht', MoneyType::class, [
//                'mapped' => false,
                'label' => 'Total HT',
            ])
            ->add('tva', MoneyType::class, [
//                'mapped' => false,
                'label' => 'TVA 20%',
            ])
            ->add('ttc', MoneyType::class, [
//                'mapped' => false,
                'label' => 'Total TTC',
            ])
            ->add('remise', MoneyType::class, [
                'attr' => ['value' => 0]
            ])
            ->add('montant', MoneyType::class, [
                'label' => 'Reste à payer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeClient::class,
        ]);
    }
}
