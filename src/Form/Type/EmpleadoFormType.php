<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Model\EmpleadoDto;
use App\Entity\Club;

class EmpleadoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('nombre', TextType::class)
            ->add('email', TextType::class)
            ->add('telefono', TextType::class)
            ->add('fechaNacimiento', TextType::class)
            ->add('posicion', IntegerType::class)
            ->add('tipoEmpleado', IntegerType::class)
            ->add('salario', NumberType::class)
            ->add('club', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmpleadoDto::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }
}