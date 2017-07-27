<?php

namespace Sunshine\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username')->add('password')->add('email')->add('isActive')->add('realName')->add('employeeNumber')->add('orderNumber')->add('education')->add('birthday')->add('phone')->add('mobile')->add('address')->add('description')->add('citizenship')->add('createdAt')->add('updatedAt')->add('deletedAt')->add('businessUnit')->add('company')->add('title')->add('secondTitle')->add('serviceGrade')->add('type')->add('gender');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_user';
    }


}
