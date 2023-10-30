<?php

namespace App\Form;

use App\Entity\WeatherData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeatherDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('temperatureInCelsius', NumberType::class, [
                'attr' => [
                    'min' => -30,
                    'max' => 50,
                ],
                'html5' => true,
            ])
            ->add('humidity', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'html5' => true,
            ])
            ->add('pressure', NumberType::class, [
                'attr' => [
                    'min' => 900,
                    'max' => 1100,
                ],
                'html5' => true,
            ])
            ->add('city', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WeatherData::class,
        ]);
    }
}