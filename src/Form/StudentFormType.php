<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NameStudent', TextType::class,
            [
                'required' => true
            ])
            ->add('Address', TextType::class,
            [
                'required' => true
            ])
            ->add('Email', TextType::class,
            [
                'required' => true
            ])
            ->add('Birthday', DateType::class,
            [
                'widget' => 'single_text'
            ])
            ->add('PhoneNumber', IntegerType::class,
            [
                'required' => true
            ])
            ->add('Classroom',EntityType::class,
            [
                'class' => Classroom::class,
                'choice_label' => 'classname',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('Photo', FileType::class,
            [
                //'lable' => 'Student Photo',
                'data_class' => null,
                'required' => is_null($builder->getData()->getPhoto())
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
