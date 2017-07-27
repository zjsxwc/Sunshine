<?php

namespace Sunshine\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ServiceGradeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'sunshine.organization.form.serviceGrade.name'])
            ->add('code', TextType::class,
                [
                    'label' => 'sunshine.organization.form.serviceGrade.code',
                    'required' => false
                ])
            ->add('orderNum', IntegerType::class, ['label' => 'sunshine.organization.form.serviceGrade.orderNumber'])
            ->add('enabled', CheckboxType::class,
                [
                    'data' => true,
                    'label' => 'sunshine.organization.form.serviceGrade.enabled',
                    'required' => false
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'sunshine.organization.form.serviceGrade.description',
                    'required' => false
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\ServiceGrade'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_servicegrade';
    }


}
