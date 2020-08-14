<?php

namespace App\Form;

use App\Entity\Actors;
use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;




class ActorsEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class , ['label' => 'Name'])
            ->add('edad' , TextType::class , ['label' => 'Years old'])
            ->add('tiempoActivo' , TextType::class , ['label' => 'Years active'])
            ->add('estado' , TextType::class , ['label' => 'State'])
            ->add('movies',EntityType::class,[
                'class'        =>  Movies::class,
                'choice_label' => 'nombre',
                'expanded'     => true,
                'multiple'     => true,
            ])
            ->add('Edit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actors::class,
        ]);
    }
}
