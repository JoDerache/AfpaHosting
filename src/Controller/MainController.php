<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Personne;
use App\Repository\LoginRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index(LoginRepository $loginRepository,PersonneRepository $personneRepository, Request $request): Response
    {
    
        $session = $request->getSession();
        
        $user = $personneRepository->findOneBy(['numeroBeneficiaire' => $_POST['_username']]);

        return $this->render('base.html.twig', [
            'personne' => $user,
        ]);
    }
}
