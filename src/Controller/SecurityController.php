<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

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

	public function __construct(UserRepository $repository, ObjectManager $em, UserPasswordEncoderInterface $encoder)
	{
		$this->repository = $repository;
		$this->em = $em;
		$this->encoder = $encoder;
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

		$random = random_bytes(10);
		dump($random);

		if ($form->isSubmitted() && $form->isValid()) {
			$user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
			$this->em->persist($user);
			$this->em->flush();
			$this->addFlash('success', 'Votre inscription a été acceptée. Vous avez reçu un mail de confirmation à l\'adresse que vous nous avez indiqué.');

			// envoi mail

			return $this->redirectToRoute('home');
		}

		return $this->render('security/register.html.twig', [
			'current_menu' => 'register',
			'form' => $form->createView(),
		]);
	}
}
