<?php

namespace CoreBundle\Form\Type\Widget;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['preview_width'] = $options['preview_width'];
        $view->vars['preview_height'] = $options['preview_height'];
        $view->vars['error_bubbling'] = $options['error_bubbling'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'placeholder' => "クリックまたはドラッグ＆ドロップで画像を選択",
            'preview_width' => 250,
            'preview_height' => 150,
            'error_bubbling' => false,
            'required' => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'image';
    }

    public function getParent()
    {
        return HiddenType::class;
    }

}