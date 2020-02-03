<?php

namespace App\Controller;

use App\Entity\User;
use Twig\Environment;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

	/**
	 * @var UserRepository
	 */
	private $repository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $encoder;

	/**
	 * Undocumented variable
	 *
	 * @var \Swift_Mailer
	 */
	private $mail;

	/**
	 * Undocumented variable
	 *
	 * @var Environment
	 */
	private $renderer;


	public function __construct(UserRepository $repository, ObjectManager $em, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, Environment $renderer)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->encoder = $encoder;
		$this->mailer = $mailer;
		$this->renderer = $renderer;
	}

	/**
	 * @Route("/login", name="login")
	 */
	public function login(AuthenticationUtils $authenticationUtils)
	{
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();


		return $this->render('security/login.html.twig', [
			'error' => $error,
			'current_menu' => 'login'
		]);
	}

	/**
	 * @Route("/register", name="register")
	 */
	public function register(Request $request)
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$token = bin2hex(random_bytes(32));

			$user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
			$user->setActif(0);
			$user->setToken($token);

			$this->em->persist($user);
			$this->em->flush();
			$this->addFlash('success', 'Votre inscription a été acceptée. Vous avez reçu un mail de confirmation à l\'adresse que vous nous avez indiqué.');

			// envoi mail
			$message = (new \Swift_Message('Bienvenue ' . $user->getUsername() . ' ! Veuillez confirmer votre adresse mail.'))
				->setFrom('no-reply@snow-tricks.com')
				->setTo($user->getEmail())
				->setBody($this->renderer->render('emails/confirmation.html.twig', [
					'user' => $user,
				]), 'text/html');

			$this->mailer->send($message);

			return $this->redirectToRoute('home');
		}

		return $this->render('security/register.html.twig', [
			'current_menu' => 'register',
			'form' => $form->createView(),
		]);
	}
}
