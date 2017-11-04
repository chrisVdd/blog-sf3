<?php

namespace App\AdminBundle\Form;

use App\MainBundle\Entity\Post;
use App\MainBundle\Repository\CategoryRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class PostType
 * @package App\AdminBundle\Form
 */
class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('categories', EntityType::class,
                [
                    'class'         => 'App\MainBundle\Entity\Category',
                    'choice_label'  => 'name',
                    'label'         => 'Category',
                    'multiple'      => true,
                    'expanded'      => true,
                    'query_builder' => function (CategoryRepository $repository) {
                        return $repository
                            ->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    },
                ])
            ->add('images', CollectionType::class,
                [
                    'entry_type'    => PostImageType::class,
                    'entry_options' => ['label' => 'false'],
                    'allow_add'     => true,
                    'by_reference'  => false
                ]
            )
            ->add('published', CheckboxType::class,
                [
                    'required' => false
                ]
            )
            ->add('save', SubmitType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            /** @var Post $post */
            $post = $event->getData();

            if (null === $post) {
                return;
            }

            if (!$post->getPublished() || null === $post->getId()) {

                $event->getForm()->add('published', CheckboxType::class,
                    ['required' => false]
                );
            } else {
                $event->getForm()->remove('published');
            }
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'App\MainBundle\Entity\Post'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_adminbundle_post';
    }


}



//<?php
///**
// * Created by PhpStorm.
// * User: chris
// * Date: 4/11/17
// * Time: 11:55
// */
//
//namespace App\AdminBundle\Form;
//
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//use Vich\UploaderBundle\Form\Type\VichImageType;
//
///**
// * Class PostImageType
// * @package App\AdminBundle\Form
// */
//class PostImageType extends AbstractType
//{
//    /**
//     * @param FormBuilderInterface $builder
//     * @param array $options
//     */
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder->add('imageFile', VichImageType::class,
//            [
//                'required' => true,
//                'allow_delete' => true,
//                'download_label' => "DOWNLOAD",
//                'download_uri' => true,
//                'image_uri' => true,
////                'imagine_pattern' => 'the pattern'
//            ]
//        );
//    }
//
//    /**
//     * @param OptionsResolver $resolver
//     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(
//            ['data_class' => 'App\MainBundle\Entity\PostImage']
//        );
//    }
//
//    /**
//     * @return string
//     */
//    public function getBlockPrefix()
//    {
//        return 'app_adminbundle_post_image';
//    }
//}
