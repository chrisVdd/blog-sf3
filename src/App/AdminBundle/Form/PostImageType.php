<?php

namespace App\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
/**
 * Class PostImageType
 *
 * @package App\AdminBundle\Form
 */
class PostImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageFile', VichImageType::class,
            [
                'required' => true,
                'allow_delete' => true,
                'download_label' => "DOWNLOAD",
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => 'the pattern'
            ]
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\PostImage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_mainbundle_postimage';
    }


}
