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






    #[Route('/main/{id}', name: 'main')]
    public function index($id,LoginRepository $loginRepository,PersonneRepository $personneRepository, Request $request): Response
    {
        
        $user = $personneRepository->findOneBy(['idPersonne' => $id]); // ATTENTION, NE PAS PASSER L'ID DANS L'URL

        return $this->render('base.html.twig', [
            'personne' => $user,
        ]);
    }
}
