<?php

namespace Sunshine\OrganizationBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TitleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'sunshine.organization.form.title.name'])
            ->add('code', TextType::class,
                [
                    'label' => 'sunshine.organization.form.title.code',
                    'required' => false
                ])
            ->add('type', EntityType::class,
                [
                    'class' => 'SunshineAdminBundle:Options',
                    'label' => 'sunshine.organization.form.title.type',
                    'choice_label' => 'displayName',
                    'placeholder' => 'sunshine.organization.form.org.chooseOne',
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('title')
                            ->select('title')
                            ->innerJoin('SunshineAdminBundle:Choice', 'c')
                            ->andWhere('c.name = :name')
                            ->setParameter('name', '岗位类别')
                            ->andWhere('title.source = c');
                    }
                ])
            ->add('orderNumber', IntegerType::class, ['label' => 'sunshine.organization.form.title.orderNumber'])
            ->add('enabled', CheckboxType::class,
                [
                    'data' => true,
                    'label' => 'sunshine.organization.form.title.enabled',
                    'required' => false
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'sunshine.organization.form.title.description',
                    'required' => false
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\Title'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_title';
    }


}
