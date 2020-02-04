<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figures;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\FiguresRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
	/**
	 * @var CommentRepository
	 */
	private $repository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(CommentRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	 * @Route("/figure/{slug}-{id}", name="figure.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @return Response
	 * @param figure $figure
	 */
	public function show(Figures $figure, string $slug, Request $request): Response
	{
		$user = $this->getUser();
		$comments = $this->repository->findAll();

		if ($user) {
			$comment = new Comment();
			$form = $this->createForm(CommentType::class, $comment);
			$form->handleRequest($request);

			if ($form->isSubmitted() && $form->isValid()) {
				$date = new \DateTime();
				$comment->setCreatedAt($date);
				$comment->setFigure($figure);
				$comment->setUser($user);

				$this->em->persist($comment);
				$this->em->flush();
				$this->addFlash('success', 'Le commentaire a bien été rajouté');

				return $this->redirectToRoute('figure.show', [
					'id' => $figure->getId(),
					'slug' => $figure->getSlug()
				], 301);
			} else {
				$this->addFlash('error', 'Le commentaire n\'a pas été rajouté, un problème est survenu');
				return $this->redirectToRoute('home');
			}
		}


		if ($slug === $figure->getSlug()) {
			return $this->render('figure/show.html.twig', [
				'figure' => $figure,
				'current_menu' => 'figure.show',
				'date_is_same' => $figure->dateIsSame(),
				'comments' => $comments,
				'form' => isset($form) && $form ? $form->createView() : false,
			]);
		}

		return $this->render('figure/show.html.twig', [
			'id' => $figure->getId(),
			'slug' => $figure->getSlug()
		]);
	}
}
