<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['max' => 3000],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Напишите новый пост',
                    ]),
                    new Length([
                        'max' => 3000,
                        'maxMessage' => 'Вы превысили допустимое количество символов',
                    ]),
                ],
            ]);

        if ($this->security->getUser() === null) {
            $builder
                ->add('email', EmailType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Введите email',
                        ]),
                        new Email([
                            'message' => 'Введите email',
                        ]),
                        new Length([
                            'max' => 180,
                            'maxMessage' => 'Вы превысили допустимое количество символов',
                        ]),
                    ],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
