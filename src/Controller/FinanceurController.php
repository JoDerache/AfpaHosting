<?php

namespace App\Controller;

use App\Entity\Financeur;
use App\Form\FinanceurType;
use App\Repository\FinanceurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/financeur')]
class FinanceurController extends AbstractController
{
    #[Route('/', name: 'app_financeur_index', methods: ['GET'])]
    public function index(FinanceurRepository $financeurRepository): Response
    {
        return $this->render('financeur/index.html.twig', [
            'financeurs' => $financeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_financeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FinanceurRepository $financeurRepository): Response
    {
        $financeur = new Financeur();
        $form = $this->createForm(FinanceurType::class, $financeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $financeurRepository->save($financeur, true);

            return $this->redirectToRoute('app_financeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financeur/new.html.twig', [
            'financeur' => $financeur,
            'form' => $form,
        ]);
    }

    #[Route('/{idFinanceur}', name: 'app_financeur_show', methods: ['GET'])]
    public function show(Financeur $financeur): Response
    {
        return $this->render('financeur/show.html.twig', [
            'financeur' => $financeur,
        ]);
    }

    #[Route('/{idFinanceur}/edit', name: 'app_financeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Financeur $financeur, FinanceurRepository $financeurRepository): Response
    {
        $form = $this->createForm(FinanceurType::class, $financeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $financeurRepository->save($financeur, true);

            return $this->redirectToRoute('app_financeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financeur/edit.html.twig', [
            'financeur' => $financeur,
            'form' => $form,
        ]);
    }

    #[Route('/{idFinanceur}', name: 'app_financeur_delete', methods: ['POST'])]
    public function delete(Request $request, Financeur $financeur, FinanceurRepository $financeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$financeur->getIdFinanceur(), $request->request->get('_token'))) {
            $financeurRepository->remove($financeur, true);
        }

        return $this->redirectToRoute('app_financeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
