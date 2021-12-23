<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Tags;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('imageFile', FileType::class,[
                'required' => false
            ])
            ->add('tags', EntityType::class,[
                'class'=>Tags::class,
                'label'=> 'Tags',
                'required'=> false,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}