<?php

namespace App\Controller\Admin;

use App\Entity\Figures;
use App\Form\FigureType;
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
     */
    private $em;

    public function __construct(FiguresRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.figure.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $figures = $this->repository->findAll();
        return $this->render('admin/figure/index.html.twig', [
            'figures' => $figures,
            'current_menu' => 'admin.figure.index',
        ]);
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
            $this->em->persist($figure);
            $this->em->flush();
            $this->addFlash('success', 'La figure a bien été créée');
            return $this->redirectToRoute('admin.figure.index');
        }

        return $this->render('admin/figure/new.html.twig', [
            'figure' => $figure,
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
            $this->em->flush();
            $this->addFlash('success', 'La figure a bien été modifiée');
            return $this->redirectToRoute('admin.figure.index');
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
    public function delete(Figures $figure, Request $request) {
        if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->get('_token'))) {
            $this->em->remove($figure);
            $this->em->flush();
            $this->addFlash('success', 'La figure a bien été supprimée');
        }
        return $this->redirectToRoute('admin.figure.index');
    }

}
