<?php

namespace App\Controller;

use App\Repository\FiguresRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(FiguresRepository $repository): Response
    {
        $figures = $repository->findAll();
        return $this->render('./home.html.twig', [
            'current_menu' => 'home',
            'figures' => $figures
        ]);
    }
}
