<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ResetPasswordUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserValidate extends AbstractController
{
	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(ObjectManager $em)
	{
		$this->em = $em;
	}

	/**
	 * @Route("/validate-user/{idUser}/{token}", name="security.validate.user")
	 */
	public function validateUser(Request $request, User $user)
	{
		$params = $request->attributes->get('_route_params');
		$id = $params['idUser'];
		$token = $params['token'];
		$user = $this->getDoctrine()
			->getRepository(User::class)
			->find($id);

		if ($user->getToken() === $token) {
			$user->setToken(null);
			$user->setActif(1);
			$this->em->persist($user);
			$this->em->flush();
			$this->addFlash('success', 'Inscription confirmée');

			return $this->redirectToRoute('home');
		}
	}

	/**
	 * @Route("/reset-password/{id}/{token}", name="security.reset.user")
	 */
	public function resetPassword(Request $request, User $user): Response
	{
		$params = $request->attributes->get('_route_params');
		$id = $params['id'];
		$token = $params['token'];
		$user = $this->getDoctrine()
			->getRepository(User::class)
			->find($id);

		if ($user->getToken() === $token) {
			$user->setToken(null);
			$this->em->persist($user);
			$this->em->flush();

			$form = $this->createForm(ResetPasswordUserType::class, $user);
			$form->handleRequest($request);

			return $this->render('security/reset-password.html.twig', [
				'current_menu' => 'register',
				'form' => $form->createView(),
			]);
		}
	}
}
