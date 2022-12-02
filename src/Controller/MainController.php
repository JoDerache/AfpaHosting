<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\BailRepository;
use App\Repository\ConsigneHebergementRepository;
use App\Repository\LoginRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/redirection', name: 'redirection')]
    public function redirection(PersonneRepository $personneRepository, Request $request, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $role = $utilisateur->getIdLogin()->getRole();

        if($role == 'ROLE_ADMIN'){
            return $this->redirectToRoute('main');
        }
        else{
            return $this->redirectToRoute('main_user');
        }
    }


    #[Route('/admin/main', name: 'main')]
    public function index(PersonneRepository $personneRepository, Request $request, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        return $this->render('main/admin_main.html.twig', [
            'controller_name' => 'MainController',
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/user/main', name: 'main_user')]
    public function indexUser(PersonneRepository $personneRepository, Request $request, BailRepository $bailRepository, UserInterface $user, ConsigneHebergementRepository $consigneHebergementRepository): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        
        // dd($utilisateur);
        $bail=$bailRepository->findAll();
        // dd($bail);

        $consignes=$consigneHebergementRepository->findAll();
        // dd($consigne);
        return $this->render('main/heberger_main.html.twig', [
            'controller_name' => 'MainController',
            'bail'=>end($bail),
            'utilisateur' => $utilisateur,
            'consignes'=>$consignes,
        ]);
    }
}


