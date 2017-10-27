<?php

namespace App\AdminBundle\Form;

use App\MainBundle\Entity\Post;
use App\MainBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $pattern = 'D%';

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
            ->add('images', FileType::class)
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
