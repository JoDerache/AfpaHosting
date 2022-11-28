<?php

namespace App\Controller;

use App\Entity\Bail;
use App\Entity\Login;
use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\UserFormType;
use App\Form\UpdatePersonneType;
use App\Repository\BailRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/personne')]
class PersonneController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/', name: 'app_personne_index')]
    public function index(Request $request,PersonneRepository $personneRepository, BailRepository $bailRepository, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $personne = new Personne();
        $login = new Login();
        $form = $this->createForm(UserFormType::class, ['user' => $personne, 'login' => $login]);
        $form->handleRequest($request);

    try {
        if ($form->isSubmitted() && $form->isValid()) {
        
        $login->setMdp(password_hash('Afpa'.$login->getNumeroBeneficiaire().'!', PASSWORD_ARGON2I));
        $this->entityManager->persist($login);
        $personne->setNumeroBeneficiaire($login->getNumeroBeneficiaire());
        $personne->setIdLogin($login);
        $personne->setIsBlacklisted(false);

        $this->entityManager->persist($personne);
        $this->entityManager->flush();
        
        
            $this->addFlash('success', 'Nouvel hébergé ajouté !');
            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }
    } catch (\Throwable $th) {
        $this->addFlash('error', 'Le numéro de bénéficiaire est déjà attribué !');
        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }

        return $this->renderForm('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'bails' => $bailRepository->findAll(),
            'utilisateur' => $utilisateur,
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

    #[Route('/{idPersonne}', name: 'app_personne_show', methods: ['GET', 'POST'])]
    public function showStudent(Personne $personne, PersonneRepository $personneRepository, ParticipationRepository $participationRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $participe = $participationRepository->findBy(['idPersonne'=>$personne->getIdPersonne()]);
        $participe2=end($participe);

        $form = $this->createForm(UpdatePersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);

            return $this->renderForm('personne/profil_Herberge.html.twig', [
                'personne' => $personne,
                'participation' => $participe2,
                'form' => $form
            ]);
        }

        return $this->renderForm('personne/profil_Herberge.html.twig', [
            'personne' => $personne,
            'participation' => $participe2,
            'form' => $form
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
