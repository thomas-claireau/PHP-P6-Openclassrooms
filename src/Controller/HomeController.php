<?php

namespace App\Controller;

use App\Repository\FiguresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

		$encoders = [new XmlEncoder(), new JsonEncoder()];
		$normalizers = [new ObjectNormalizer()];
		$serializer = new Serializer($normalizers, $encoders);

		if (is_int($index) && $index > 1) {
			$moreFigures = $serializer->normalize($this->figuresRepository->findMoreItems($index), 'json');
			return new JsonResponse(json_encode($moreFigures), 200, array('Content-Type' => 'application/json'));
		} else {
			return new JsonResponse(['error' => 'Une erreur est survenue'], 400);
		}
	}
}
