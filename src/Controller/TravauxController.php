<?php

namespace App\Controller;

use App\Entity\Travaux;
use App\Form\TravauxType;
use App\Repository\TravauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/travaux')]
class TravauxController extends AbstractController
{
    #[Route('/', name: 'app_travaux_index', methods: ['GET'])]
    public function index(TravauxRepository $travauxRepository): Response
    {
        return $this->render('travaux/index.html.twig', [
            'travauxes' => $travauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_travaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TravauxRepository $travauxRepository): Response
    {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travauxRepository->save($travaux, true);

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route('/{idTravaux}', name: 'app_travaux_show', methods: ['GET'])]
    public function show(Travaux $travaux): Response
    {
        return $this->render('travaux/show.html.twig', [
            'travaux' => $travaux,
        ]);
    }

    #[Route('/{idTravaux}/edit', name: 'app_travaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travaux $travaux, TravauxRepository $travauxRepository): Response
    {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travauxRepository->save($travaux, true);

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route('/{idTravaux}', name: 'app_travaux_delete', methods: ['POST'])]
    public function delete(Request $request, Travaux $travaux, TravauxRepository $travauxRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travaux->getIdTravaux(), $request->request->get('_token'))) {
            $travauxRepository->remove($travaux, true);
        }

        return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
