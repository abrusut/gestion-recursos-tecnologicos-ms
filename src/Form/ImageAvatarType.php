<?php


namespace App\Form;


use App\Entity\Image;
use App\Entity\ImageAvatar;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'label' => 'label.file',
            'required' => false
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageAvatar::class,
            'csrf_protection' => false
        ]);
    }
    
    public function getBlockPrefix()
    {
        return '';
    }
    
}