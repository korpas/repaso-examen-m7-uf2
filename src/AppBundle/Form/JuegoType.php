<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JuegoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, ['error_bubbling' => true, 'attr' => ['class' => 'anyClass']])
            ->add('precio', IntegerType::class, ['error_bubbling' => true])
            ->add('plataforma', TextType::class, ['error_bubbling' => true])
            ->add('pEGI', TextType::class, ['error_bubbling' => true])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Juego',
            ]
        );

    }

    public function getName()
    {
        return 'app_bundle_juego_type';
    }
}
