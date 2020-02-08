<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/picture")
 */
class AdminPictureController extends AbstractController
{
	/**
	 * @Route("/new", name="admin.picture.new", methods={"GET","POST"})
	 */
	public function new(Request $request): Response
	{
		$picture = new Picture();
		$form = $this->createForm(PictureType::class, $picture);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($picture);
			$entityManager->flush();

			return $this->redirectToRoute('home');
		}

		return $this->render('admin/picture/new.html.twig', [
			'picture' => $picture,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}/edit", name="admin.picture.edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Picture $picture): Response
	{
		$form = $this->createForm(PictureType::class, $picture);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('picture_index');
		}

		return $this->render('admin/picture/edit.html.twig', [
			'picture' => $picture,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin.picture.delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Picture $picture): Response
	{
		if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($picture);
			$entityManager->flush();
		}

		// return $this->render('admin/figure/edit.html.twig', [
		// 	'figure' => $figure,
		// 	'form'     => $form->createView(),
		// 	'current_menu' => 'admin.figure.edit',
		// ]);
	}
}
