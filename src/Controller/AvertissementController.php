<?php

namespace App\Controller;

use App\Entity\Avertissement;
use App\Form\AvertissementType;
use App\Repository\AvertissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/avertissement')]
class AvertissementController extends AbstractController
{
    #[Route('/', name: 'app_avertissement_index', methods: ['GET'])]
    public function index(AvertissementRepository $avertissementRepository): Response
    {
        return $this->render('avertissement/index.html.twig', [
            'avertissements' => $avertissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avertissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AvertissementRepository $avertissementRepository): Response
    {
        $avertissement = new Avertissement();
        $form = $this->createForm(AvertissementType::class, $avertissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avertissementRepository->save($avertissement, true);

            return $this->redirectToRoute('app_avertissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avertissement/new.html.twig', [
            'avertissement' => $avertissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idAvertissement}', name: 'app_avertissement_show', methods: ['GET'])]
    public function show(Avertissement $avertissement): Response
    {
        return $this->render('avertissement/show.html.twig', [
            'avertissement' => $avertissement,
        ]);
    }

    #[Route('/{idAvertissement}/edit', name: 'app_avertissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avertissement $avertissement, AvertissementRepository $avertissementRepository): Response
    {
        $form = $this->createForm(AvertissementType::class, $avertissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avertissementRepository->save($avertissement, true);

            return $this->redirectToRoute('app_avertissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avertissement/edit.html.twig', [
            'avertissement' => $avertissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idAvertissement}', name: 'app_avertissement_delete', methods: ['POST'])]
    public function delete(Request $request, Avertissement $avertissement, AvertissementRepository $avertissementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avertissement->getIdAvertissement(), $request->request->get('_token'))) {
            $avertissementRepository->remove($avertissement, true);
        }

        return $this->redirectToRoute('app_avertissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
