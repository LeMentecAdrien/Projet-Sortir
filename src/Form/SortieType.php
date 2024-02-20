<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('etat')
            ->add('participants', EntityType::class, [
                'class' => Participant::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('organisateur', EntityType::class, [
                'class' => Participant::class,
'choice_label' => 'id',
            ])
            ->add('Site', EntityType::class, [
                'class' => Site::class,
'choice_label' => 'id',
            ])
            ->add('Etat', EntityType::class, [
                'class' => Etat::class,
'choice_label' => 'id',
            ])
            ->add('Lieu', EntityType::class, [
                'class' => Lieu::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
