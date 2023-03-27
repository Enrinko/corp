<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Имя пользователя',
                'attr' => [
                    'placeholder' => 'Имя пользователя'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Номер телефона',
                'attr' => [
                    'placeholder' => 'Номер телефона'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Электронная почта',
                'attr' => [
                    'placeholder' => 'Электронная почта'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать.',
                'options' => [
                    'attr' => [
                        'class' => 'password-field form-floating',
                    ]],
                'required' => true,
                'first_options'  => [
                    'label' => 'Пароль',
                    'attr' => [
                        'placeholder' => 'Пароль'
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                ],
                'second_options' => [
                    'label' => 'Повторите пароль',
                    'attr' => [
                        'placeholder' => 'Повторите пароль'
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                ],
            ])
            ->add('captcha', ReCaptchaType::class, [
                'required' => true,
                'invalid_message' => 'Пройдите капчу, чтобы продолжить',
            ])
            ->add('isAgreed', CheckboxType::class, [
                'label' => 'Согласен с Политикой конфиденциальности и Условиями пользования'
            ])
            ->add('dateOfReg', HiddenType::class, [
                'data' => new \DateTime()
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'just_LogIn',
        ]);
    }
}
