<?php

namespace App\Controller;

use App\Entity\Bail;
use App\Entity\Login;
use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\UpdatePasswordType;
use App\Form\UpdatePersonneType;
use App\Repository\BailRepository;
use App\Repository\LoginRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'app_personne_index', methods: ['GET'])]
    public function index(PersonneRepository $personneRepository, BailRepository $bailRepository): Response
    {
        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'bails' => $bailRepository->findAll()
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

    // #[Route('/{idPersonne}', name: 'app_personne_show', methods: ['GET'])]
    // public function show(Personne $personne): Response
    // {
    //     return $this->render('personne/show.html.twig', [
    //         'personne' => $personne,
    //     ]);
    // }

    #[Route('/{idPersonne}', name: 'app_personne_show', methods: ['GET', 'POST'])]
    public function showStudent(Personne $personne, PersonneRepository $personneRepository, ParticipationRepository $participationRepository, Request $request, EntityManagerInterface $manager, ): Response
    {
        // dd($participationRepository->findBy(['idPersonne'=>491]));
    $participe = $participationRepository->findBy(['idPersonne'=>$personne->getIdPersonne()]);
    $participe2=end($participe);
    // dd($participe);

        $form = $this->createForm(UpdatePersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);

            // $personne = $form->getData();
            // $manager->persist($personne);
            // $manager->flush();

            return $this->renderForm('personne/profil_Herberge.html.twig', [
                'personne' => $personne,
                'participation' => $participe2,
                'form' => $form
            ]);
        }

        // $formPW = $this->createForm(UpdatePasswordType::class, $login);
        // $formPW->handleRequest($request);
        // if ($formPW->isSubmitted() && $formPW->isValid()) {
        //     $loginRepository->save($login, true);

        //     return $this->renderForm('personne/profil_Herberge.html.twig', [
        //         'login' => $login,
        //         'form' => $formPW
        //     ]);
        // }

        
        return $this->renderForm('personne/profil_Herberge.html.twig', [
            'personne' => $personne,
            'participation' => $participe2,
            'form' => $form
        ]);
    }

    #[Route('/{idPersonne}/newPW', name: 'app_personne_edit', methods: ['GET', 'POST'])]
    public function editPW(Personne $personne, PersonneRepository $personneRepository, EntityManagerInterface $manager, LoginRepository $loginRepository, Request $request, ): Response
    {
        // dd($personne);
        $idlogin = $personne->getIdLogin();
        $loginUser = $loginRepository ->find($idlogin);
        // dd($loginUser);
    
        
        $form=$this->createForm(UpdatePasswordType::class, $loginUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);


            return $this->renderForm('personne/profil_Herberge.html.twig', [
                'personne' => $personne,
                'form' => $form
            ]);
        }
            return $this->renderForm('personne/testUpdatePassword.html.twig', [
                'personne' => $personne,
                'form' => $form
            ]);
    }





    // #[Route('/{idPersonne}/edit', name: 'app_personne_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    // {
    //     $form = $this->createForm(PersonneType::class, $personne);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $personneRepository->save($personne, true);

    //         return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('personne/edit.html.twig', [
    //         'personne' => $personne,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{idPersonne}', name: 'app_personne_delete', methods: ['POST'])]
    public function delete(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getIdPersonne(), $request->request->get('_token'))) {
            $personneRepository->remove($personne, true);
        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }
}
