<?php

namespace App\Controller;

use App\Entity\Bail;
use App\Form\BailType;
use App\Repository\BailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/bail')]
class BailController extends AbstractController
{
    #[Route('/', name: 'app_bail_index', methods: ['GET'])]
    public function index(BailRepository $bailRepository): Response
    {
        return $this->render('bail/index.html.twig', [
            'bails' => $bailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BailRepository $bailRepository): Response
    {
        $bail = new Bail();
        $form = $this->createForm(BailType::class, $bail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bailRepository->save($bail, true);

            return $this->redirectToRoute('app_bail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bail/new.html.twig', [
            'bail' => $bail,
            'form' => $form,
        ]);
    }

    #[Route('/{idBail}', name: 'app_bail_show', methods: ['GET'])]
    public function show(Bail $bail): Response
    {
        return $this->render('bail/show.html.twig', [
            'bail' => $bail,
        ]);
    }

    #[Route('/{idBail}/edit', name: 'app_bail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bail $bail, BailRepository $bailRepository): Response
    {
        $form = $this->createForm(BailType::class, $bail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bailRepository->save($bail, true);

            return $this->redirectToRoute('app_bail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bail/edit.html.twig', [
            'bail' => $bail,
            'form' => $form,
        ]);
    }

    #[Route('/{idBail}', name: 'app_bail_delete', methods: ['POST'])]
    public function delete(Request $request, Bail $bail, BailRepository $bailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bail->getIdBail(), $request->request->get('_token'))) {
            $bailRepository->remove($bail, true);
        }

        return $this->redirectToRoute('app_bail_index', [], Response::HTTP_SEE_OTHER);
    }
}
