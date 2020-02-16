<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Repository\FiguresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
	/**
	 * @var FiguresRepository
	 */
	private $figuresRepository;

	public function __construct(FiguresRepository $figuresRepository)
	{
		$this->figuresRepository = $figuresRepository;
	}

	/**
	 * @Route("/", name="home")
	 *
	 * @return Response
	 */
	public function index(): Response
	{
		$figures = $this->figuresRepository->findItems();
		$nbGroups = round($this->figuresRepository->countAll() / 15);

		return $this->render('./home.html.twig', [
			'current_menu' => 'home',
			'figures' => $figures,
			'nbGroups' => $nbGroups
		]);
	}

	/**
	 * @Route("/index/{index}", name="home.index")
	 *
	 * @return Response
	 */
	public function ajaxLoadItems(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$index = (int) $params['index'];
		$nbGroups = round($this->figuresRepository->countAll() / 15);

		if (is_int($index) && $index > 1) {
			$moreFigures = (array) $this->figuresRepository->findMoreItems($index);
			$htmlData = [];

			if ($moreFigures) {
				foreach ($moreFigures as $figure) {
					$figure = $this->getDoctrine()
						->getRepository(Figures::class)
						->find($figure['id']);

					array_push(
						$htmlData,
						$this->renderView('./figure/_figure.html.twig', [
							'current_menu' => 'home',
							'figure' => $figure,
							'nbGroups' => $nbGroups,
						])
					);
				}
			}

			return new JsonResponse([
				'html' => $htmlData,
			], 200);
		}

		return new JsonResponse(['error' => 'Une erreur est survenue'], 400);
	}
}
