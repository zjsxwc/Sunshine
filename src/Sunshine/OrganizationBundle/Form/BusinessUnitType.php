<?php

namespace Sunshine\OrganizationBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessUnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'sunshine.organization.form.bu.name'])
            ->add('code', TextType::class, ['label' => 'sunshine.organization.form.bu.code'])
            ->add('orderNumber', IntegerType::class, ['label' => 'sunshine.organization.form.bu.orderNumber'])
            ->add('company', CompanyNameHiddenType::class)
            ->add('parent', BusinessUnitParentHiddenType::class)
            ->add('enabled', CheckboxType::class,
                [
                    'data' => true,
                    'label' => 'sunshine.organization.form.bu.enabled',
                    'required' => false
                ])
            ->add('createSpace', CheckboxType::class,
                [
                    'label' => 'sunshine.organization.form.bu.createSpace',
                    'required' => false
                ])
            ->add('manager', EntityType::class,
                [
                    'class' => 'Sunshine\OrganizationBundle\Entity\User',
                    'label' => 'sunshine.organization.form.bu.manager'
                ])
            ->add('preManager', EntityType::class,
                [
                    'class' => 'Sunshine\OrganizationBundle\Entity\User',
                    'label' => 'sunshine.organization.form.bu.preManager'
                ])
            ->add('businessUnitAdmin', EntityType::class,
                [
                    'class' => 'Sunshine\OrganizationBundle\Entity\User',
                    'label' => 'sunshine.organization.form.bu.businessUnitAdmin'
                ])
            ->add('documentReceiver', EntityType::class,
                [
                    'class' => 'Sunshine\OrganizationBundle\Entity\User',
                    'label' => 'sunshine.organization.form.bu.documentReceiver'
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'sunshine.organization.form.bu.description',
                    'required' => false
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\BusinessUnit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_businessunit';
    }


}
