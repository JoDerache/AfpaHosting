<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Personne;
use App\Form\UpdatePersonneAdminType;
use App\Form\UserFormType;
use App\Repository\BailRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    public function index(Request $request,PersonneRepository $personneRepository, UserInterface $user): Response
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
            'utilisateur' => $utilisateur,
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route('/byBail', name: 'app_personne_indexByBail', methods: ['GET'])]
    public function indexByBail(Request $request, PersonneRepository $personneRepository, BailRepository $bailRepository, ManagerRegistry $doctrine, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $personne = new Personne();
        $login = new Login();
        $form = $this->createForm(UserFormType::class, ['user' => $personne, 'login' => $login]);
        $form->handleRequest($request);


        //Requête pour récupérer toutes les infos liées aux hebergés ayant un bail et une formation
        $connection = $doctrine->getConnection();

        $sql = 'SELECT b.id_bail,
                       pe.id_personne,
                       pe.badge, 
                       pe.nom,
                       pe.prenom,
                       b.date_entree,
                       b.date_sortie,
                       b.numero_chambre,
                       p.date_entree AS debut_formation,
                       p.date_sortie AS fin_formation,
                       f.nom AS financeur,
                       fo.nom_formation AS formation
                FROM hebergementafpa.bail AS b
                INNER JOIN hebergementafpa.participation AS p ON p.id_personne = b.id_personne
                INNER JOIN hebergementafpa.financeur AS f ON f.id_financeur = p.id_financeur
                INNER JOIN hebergementafpa.formations AS fo ON fo.id_formation = p.id_formation
                INNER JOIN hebergementafpa.personne AS pe ON pe.id_personne = b.id_personne';

        $stmt = $connection->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $heberges = $resultSet->fetchAll();

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

        return $this->renderForm('personne/indexByBail.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'bails' => $bailRepository->findAll(),
            'utilisateur' => $utilisateur,
            'form' => $form,
            'heberges' => $heberges,
        ]);
    }

    #[Route('/{id}', name: 'app_personne_show', methods: ['GET', 'POST'])]
    public function show(PersonneRepository $personneRepository, ParticipationRepository $participationRepository, UserInterface $user, Request $request, $id): Response
    {

        /**
         * récupération de 'identité de l'utilisateur
         */
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $profilHeberge = $personneRepository->findBy(['idPersonne' => $id]);
        $profilHeberge = current($profilHeberge);

        /**
         * Pour la mise à jour des informations de profil
         */
        $participe = $participationRepository->findBy(['idPersonne' => $id]);
        $participe2 = end($participe);

        $form = $this->createForm(UpdatePersonneAdminType::class, $profilHeberge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($profilHeberge, true);
          
            $this->addFlash(
                'success',
                'Les informations de profil ont bien été modifiées.'
            );

        } else if (($form->isSubmitted() && !$form->isValid())) {
            $this->addFlash(
                'warning',
                'Une erreur s\'est produite');
        }

        return $this->renderForm('personne/show.html.twig', [
            'personne' => $profilHeberge,
            'participation' => $participe2,
            'form' => $form,
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/{idPersonne}', name: 'app_personne_delete', methods: ['POST'])]
    public function delete(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personne->getIdPersonne(), $request->request->get('_token'))) {
            $personneRepository->remove($personne, true);
        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }
}
