<?php

namespace App\Controller;

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

		return $this->render('./home.html.twig', [
			'current_menu' => 'home',
			'figures' => $figures
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

		if (is_int($index) && $index > 1) {
			$moreFigures = $this->figuresRepository->findMoreItems($index);
			return new JsonResponse($moreFigures, 200, array('Content-Type' => 'application/json'));
		} else {
			return new JsonResponse(['error' => 'Une erreur est survenue'], 400);
		}
	}
}
