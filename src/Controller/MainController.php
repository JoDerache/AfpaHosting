<?php

namespace App\Controller;

use App\Entity\Personne;
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


    #[Route('/main', name: 'main')]
    public function index(PersonneRepository $personneRepository, Request $request, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'utilisateur' => $utilisateur
        ]);
    }
}
