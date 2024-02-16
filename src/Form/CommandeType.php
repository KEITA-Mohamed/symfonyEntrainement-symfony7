<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numCommande',TextType::class,[
                'label'=>'N°',
                'label_attr'=>['class'=>''],
                'attr'=>['class'=>''],
            ])

            ->add('dateCommande',DateType::class,[
                'label'=>'DateCommande:',
                'label_attr'=>['class'=>''],
                'attr'=>['class'=>''],
            ])
            ->add('client', EntityType::class, [
                'label'=>'client:',
                'label_attr'=>['class'=>''],
                'attr'=>['class'=>''],
                'class' => Client::class,
                'choice_label' => 'nomClient',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
