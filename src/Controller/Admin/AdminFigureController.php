<?php

namespace App\Controller\Admin;

use App\Entity\Figures;
use App\Entity\Picture;
use App\Form\FigureType;
use App\Form\PictureType;
use App\Repository\FiguresRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFigureController extends AbstractController
{

	/**
	 * @var FiguresRepository
	 */
	private $repository;
	/**
	 * @var ObjectManager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	public function __construct(FiguresRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	 * @Route("/admin/figure/create", name="admin.figure.new")
	 */
	public function new(Request $request)
	{
		$figure = new Figures();
		$form = $this->createForm(FigureType::class, $figure);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$date = new \DateTime();
			$figure->setCreatedAt($date);
			$figure->setUpdatedAt($date);

			$this->em->persist($figure);
			$this->em->flush();
			$this->addFlash('success', 'La figure a bien été créée');
			return $this->redirectToRoute('home');
		}

		$lastId = $this->repository->getLastId()->getId();

		return $this->render('admin/figure/new.html.twig', [
			'figure' => $figure,
			'idFigure' => $lastId + 1,
			'form'     => $form->createView(),
			'current_menu' => 'admin.figure.new',
		]);
	}

	/**
	 * @Route("/admin/figure/{id}", name="admin.figure.edit", methods="GET|POST")
	 * @param Figures $figure
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function edit(Figures $figure, Request $request)
	{
		$form = $this->createForm(FigureType::class, $figure);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$date = new \DateTime();
			$figure->setUpdatedAt($date);

			$this->em->flush();
			$this->addFlash('success', 'La figure a bien été modifiée');
			return $this->redirectToRoute('home');
		}

		return $this->render('admin/figure/edit.html.twig', [
			'figure' => $figure,
			'form'     => $form->createView(),
			'current_menu' => 'admin.figure.edit',
		]);
	}

	/**
	 * @Route("/admin/figure/{id}", name="admin.figure.delete", methods="DELETE")
	 * @param Figures $figure
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function delete(Figures $figure, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->get('_token'))) {
			$this->em->remove($figure);
			$this->em->flush();
			$this->addFlash('success', 'La figure a bien été supprimée');
		} else {
			$this->addFlash('error', 'La figure n\'a pas été supprimée, un problème est survenu');
			return $this->redirectToRoute('home');
		}
		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/admin/figure/mainImg/{id}", name="admin.figure.mainImg.delete", methods="DELETE")
	 * @param Figures $figure
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function deleteMainImg(Figures $figure, Request $request)
	{
		if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->get('_token'))) {
			$figure->setMainImage(null);
			$figure->setUpdatedAt(new \DateTime());
			$this->em->flush();
			$this->addFlash('success', 'L\'image principale de la figure a bien été supprimée');
		} else {
			$this->addFlash('error', 'La figure n\'a pas été supprimée, un problème est survenu');
			return $this->redirectToRoute('home');
		}
		return $this->redirectToRoute('home');
	}
}
