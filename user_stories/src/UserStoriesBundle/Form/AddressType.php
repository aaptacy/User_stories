<?php

namespace UserStoriesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserStoriesBundle\Entity\User;
use UserStoriesBundle\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Router;

class AddressType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('city', TextType::class, ['label' => 'Miasto'])
                ->add('street', TextType::class, ['label' => 'Ulica'])
                ->add('number', NumberType::class, ['label' => 'Numer domu'])
                ->add('flatNumber', NumberType::class, ['label' => 'Numer mieszkania']);           
    }
    
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserStoriesBundle\Entity\Address'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userstoriesbundle_address';
    }


}
