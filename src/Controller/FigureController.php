<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figures;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\FiguresRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
	/**
	 * @var CommentRepository
	 */
	private $commentRepository;

	/**
	 * @var FiguresRepository
	 */
	private $figuresRepository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(CommentRepository $commentRepository, FiguresRepository $figuresRepository, ObjectManager $em)
	{
		$this->commentRepository = $commentRepository;
		$this->figuresRepository = $figuresRepository;
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
		$comments = $this->commentRepository->findItems();

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
			}
		}


		if ($slug === $figure->getSlug()) {
			return $this->render('figure/show.html.twig', [
				'figure' => $figure,
				'id' => $figure->getId(),
				'slug' => $figure->getSlug(),
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

	/**
	 * @Route("/figure/{id}/commentaire/index/{index}", name="figure.commentaire.index")
	 *
	 * @return Response
	 */
	public function ajaxLoadItems(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$index = (int) $params['index'];
		$nbGroups = round($this->commentRepository->countAll() / 10);

		// $encoders = [new XmlEncoder(), new JsonEncoder()];
		// $defaultContext = [
		// 	AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
		// 		return $object->getId();
		// 	},
		// ];
		// $normalizers = [new ObjectNormalizer];
		// $normalizers = [new ObjectNormalizer()];
		// $serializer = new Serializer($normalizers, $encoders);

		if (is_int($index) && $index > 1) {
			$moreComments = (array) $this->commentRepository->findMoreItems($index);
			$htmlData = [];

			if ($moreComments) {
				foreach ($moreComments as $comment) {
					array_push(
						$htmlData,
						$this->renderView('./comment.twig', [
							'comment' => $comment,
							'nbGroups' => $nbGroups,
						])
					);
				}
			}

			return new JsonResponse([
				'html' => $htmlData,
			], 200);
		} else {
			return new JsonResponse(['error' => 'Une erreur est survenue'], 400);
		}
	}
}
