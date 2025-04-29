<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('author', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('genre', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('isbn', null, [

                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('publication_date', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('pages', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('publisher', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('language', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('Status', ChoiceType::class, [
                'choices'  => [
                    'Available' => 'available',
                    'Loaned' => 'loaned',
                    'Reserved' => 'reserved',
                    'Damaged' => 'damaged',
                ],
                'placeholder' => 'Choose a status',
                'attr' => ['class' => 'form-select'], // Usar form-select para los select inputs
                'row_attr' => ['class' => 'mb-3'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
