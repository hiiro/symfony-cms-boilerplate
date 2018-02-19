<?php

namespace AdminBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministratorType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => '名前',
                'attr' => [
                    'placeholder' => '名前'
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'ユーザー名',
                'attr' => [
                    'placeholder' => 'Username'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'パスワード',
                'attr' => [
                    'placeholder' => 'Password'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'メールアドレス',
                'attr' => [
                    'placeholder' => 'mail@example.com'
                ],
            ])
            ->add('enabled', ChoiceType::class, [
                'label' => '有効/無効',
                'choices' => [
                    '有効' => 1,
                    '無効' => 0,
                ],
                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CoreBundle\Entity\Administrator'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_administrator';
    }


}