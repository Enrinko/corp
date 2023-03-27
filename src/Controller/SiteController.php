<?php namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

class SiteController extends AbstractController
{
    private EntityManagerInterface $manager;
    private FormLoginAuthenticator $authenticator;
    public function __construct(
        FormLoginAuthenticator $authenticator,
        EntityManagerInterface $manager,
    )
    {
        $this->manager = $manager;
        $this->authenticator = $authenticator;
    }

    #[Route('/', name: "mainPage")]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/userCab', name: 'userCab')]
    public function userCab(

    ): Response
    {
        $array = [
            'user' => $this->manager->getRepository(User::class)->findBy(['username' => $this->getUser()->getUserIdentifier()])
        ];
        return $this->render('user_cab.html.twig', $array);
    }

    #[Route('/reg', name: "reg")]
    public function reg(
        Request                     $request,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserAuthenticatorInterface  $authenticator,
        EmailService                $email,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $user->setRoles($user->getRoles());
            $entityManager->getRepository(User::class)->save($user);
            $entityManager->flush();
            $rememberMe = new RememberMeBadge();
            $rememberMe->enable();
            $authenticator->authenticateUser($user, $this->authenticator, $request, [$rememberMe]);
            return $this->redirectToRoute('userCab');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Зарегистрируйтесь',
            'text' => 'Уже есть аккаунт? Войдите!',
            'toWhere' => 'login'
        ];
        return $this->render('auth.html.twig', $array);
    }

    #[Route(path: '/login', name: 'login')]
    public function login(
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $array = [
            'form' => $form->createView(),
            'title' => 'Войти',
            'text' => 'Нет аккаунта? Зарегистрируйтесь!',
            'toWhere' => 'reg',
            'method' => 'POST'
        ];
        return $this->render('auth.html.twig', $array);
    }

    #[Route('/logout', name: "logout", methods: ['GET'])]
    public function logout()
    {
    }
}