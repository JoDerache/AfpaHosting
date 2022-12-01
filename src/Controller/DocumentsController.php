<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user/documents')]
class DocumentsController extends AbstractController
{
    #[Route('/', name: 'app_documents_index', methods: ['GET'])]
    public function index(PersonneRepository $personneRepository, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        
        return $this->render('documents_Herberge/index.html.twig', ['utilisateur' => $utilisateur,]);
    }
}