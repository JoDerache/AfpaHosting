<?php

namespace App\Controller;

use App\Entity\PersonneAContacter;
use App\Form\PersonneAContacterType;
use App\Repository\PersonneAContacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne/a/contacter')]
class PersonneAContacterController extends AbstractController
{
    #[Route('/', name: 'app_personne_a_contacter_index', methods: ['GET'])]
    public function index(PersonneAContacterRepository $personneAContacterRepository): Response
    {
        return $this->render('personne_a_contacter/index.html.twig', [
            'personne_a_contacters' => $personneAContacterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_personne_a_contacter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonneAContacterRepository $personneAContacterRepository): Response
    {
        $personneAContacter = new PersonneAContacter();
        $form = $this->createForm(PersonneAContacterType::class, $personneAContacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneAContacterRepository->save($personneAContacter, true);

            return $this->redirectToRoute('app_personne_a_contacter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne_a_contacter/new.html.twig', [
            'personne_a_contacter' => $personneAContacter,
            'form' => $form,
        ]);
    }

    #[Route('/{idPersonneContact}', name: 'app_personne_a_contacter_show', methods: ['GET'])]
    public function show(PersonneAContacter $personneAContacter): Response
    {
        return $this->render('personne_a_contacter/show.html.twig', [
            'personne_a_contacter' => $personneAContacter,
        ]);
    }

    #[Route('/{idPersonneContact}/edit', name: 'app_personne_a_contacter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonneAContacter $personneAContacter, PersonneAContacterRepository $personneAContacterRepository): Response
    {
        $form = $this->createForm(PersonneAContacterType::class, $personneAContacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneAContacterRepository->save($personneAContacter, true);

            return $this->redirectToRoute('app_personne_a_contacter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne_a_contacter/edit.html.twig', [
            'personne_a_contacter' => $personneAContacter,
            'form' => $form,
        ]);
    }

    #[Route('/{idPersonneContact}', name: 'app_personne_a_contacter_delete', methods: ['POST'])]
    public function delete(Request $request, PersonneAContacter $personneAContacter, PersonneAContacterRepository $personneAContacterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personneAContacter->getIdPersonneContact(), $request->request->get('_token'))) {
            $personneAContacterRepository->remove($personneAContacter, true);
        }

        return $this->redirectToRoute('app_personne_a_contacter_index', [], Response::HTTP_SEE_OTHER);
    }
}
