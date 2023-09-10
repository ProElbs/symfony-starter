<?php

namespace App\Form;

use App\Entity\Article;
use App\Enum\ArticleStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title')
            ->add('status', ChoiceType::class, [
                'choices' => ArticleStatusEnum::getConstants()
            ])
            ->add('submit', SubmitType::class)
        ;

//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
//            $form = $event->getForm();
//            // Show here no autocomplete... we don't like that
//            /** @var Article $article */
//            $article = $event->getData();
//            if ($article->status === ArticleStatusEnum::STATUS_PUBLISHED) {
                $builder->add('tags', CollectionType::class, [ // Replace $builder by $form
                    'entry_type' => TagType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                ]);
//            }
//        });

// TODO see https://symfony.com/doc/current/form/dynamic_form_modification.html
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}