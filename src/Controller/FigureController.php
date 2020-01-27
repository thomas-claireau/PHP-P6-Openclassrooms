<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Repository\FiguresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
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
     * @Route("/figure/{slug}-{id}", name="figure.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @param figure $figure
     */
    public function show(Figures $figure, string $slug, Request $request): Response
    {
        // $contact = new Contact();
        // $contact->setfigure($figure);
        // $form = $this->createForm(ContactType::class, $contact);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $notification->notify($contact);
        //     $this->addFlash('success', 'Votre email a bien été envoyé');
        // return $this->redirectToRoute('figure.show', [
        // 	'id' => $figure->getId(),
        // 	'slug' => $figure->getSlug()
        // ]);
        // }

        if ($slug === $figure->getSlug()) {
            return $this->render('figure/show.html.twig', [
                'figure' => $figure,
                'current_menu' => 'figure.show',
                // 'form' => $form->createView()
            ]);
        }

        return $this->redirectToRoute('figure.show', [
            'id' => $figure->getId(),
            'slug' => $figure->getSlug()
        ], 301);
    }
}
