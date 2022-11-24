<?php

namespace App\Controller;

use App\Entity\Bail;
use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\BailRepository;
use App\Repository\PersonneRepository;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'app_personne_index', methods: ['GET'])]
    public function index(PersonneRepository $personneRepository, BailRepository $bailRepository, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);



        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'bails' => $bailRepository->findAll(),
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/new', name: 'app_personne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonneRepository $personneRepository): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route('/{idPersonne}', name: 'app_personne_show', methods: ['GET'])]
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/stagiaire{idPersonne}', name: 'app_personne_show', methods: ['GET'])]
    public function showStudent(Personne $personne, ParticipationRepository $participationRepository): Response
    {
        // dd($participationRepository->findBy(['idPersonne'=>491]));
    $participe = $participationRepository->findBy(['idPersonne'=>$personne->getIdPersonne()]);
    // dd($participe);
        return $this->render('personne/show2.html.twig', [
            'personne' => $personne,
            'participation' => $participe
        ]);
    }

    #[Route('/{idPersonne}/edit', name: 'app_personne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route('/{idPersonne}', name: 'app_personne_delete', methods: ['POST'])]
    public function delete(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getIdPersonne(), $request->request->get('_token'))) {
            $personneRepository->remove($personne, true);
        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }
}
