<?php

namespace App\Controller;


use App\Entity\Login;
use App\Entity\Personne;
use App\Form\UpdatePersonneType;
use App\Repository\LoginRepository;
use Symfony\Component\Form\FormError;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil')]
class ProfilController extends AbstractController

{
    #[Route('/', name: 'app_profil_show', methods: ['GET', 'POST'])]
    public function showStudent(PersonneRepository $personneRepository, ParticipationRepository $participationRepository, Request $request, LoginRepository $loginRepository, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager, UserInterface $user,): Response
    {
        /**
         * récupération de 'identité de l'utilisateur
         */
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);


        /**
         * Création du formulaire pour la modification du mot de passe 
         */
        $userPassword = array('oldMdpEmp' => '', 'mdpEmp' => '');
        $form2 = $this->createFormBuilder($userPassword)
            ->add('oldMdpEmp', PasswordType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Mot de passe actuel'])
            ->add('mdpEmp', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez le mot de passe'),
                'invalid_message' => 'Les deux mots de passe doivent correspondre',
                'options' => ['attr' => ['class' => 'form-control']],
            ])
            ->add('submit', SubmitType::class, ['attr' => ['id' => 'bouton', 'class' => 'btn btn-danger card-btn'], 'label' => 'Changer le mot de passe'])
            ->getForm();

        /**
         * Pour la mise à jours des information deprofil
         */
        $participe = $participationRepository->findBy(['idPersonne' => $utilisateur->getIdPersonne()]);
        $participe2 = end($participe);
        // dd($utilisateur);

        $form = $this->createForm(UpdatePersonneType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($utilisateur, true);
            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées.'
            );

        } else if (($form->isSubmitted() && !$form->isValid())) {
            $this->addFlash(
                'warning',
                'Une erreur c\'est produite');
        }
        
        return $this->renderForm('personne/profil_Herberge.html.twig', [
            'personne' => $utilisateur,
            'participation' => $participe2,
            'form2' => $form2,
            'form' => $form,
            'utilisateur' => $utilisateur
        ]);
        

        /**
         * Pour l'édition du mot de passe
         */

        // dd($personne);
        $idlogin = $utilisateur->getIdLogin();
        $loginUser = $loginRepository->find($idlogin);
        $login = $loginUser;

        // $form2=$this->createForm(UpdatePasswordType::class, $loginUser);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $data = $form2->getData();
            // dd($hasher->isPasswordValid($login,$data['oldMdpEmp']));
            if ($hasher->isPasswordValid($login, $data['oldMdpEmp'])) {
                $hash = $hasher->hashPassword($loginUser, $data['mdpEmp']);
                $loginUser->setMdp($hash);
                $manager->persist($loginUser);
                $manager->flush();
                // $loginRepository->save($loginUser, true);
                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );

            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe actuelle renseigné est incorrect.');
            }

        } else if (($form2->isSubmitted() && !$form2->isValid())) {
            $this->addFlash(
                'warning',
                'Les deux mots de passe doivent correspondre.');
        }
        return $this->renderForm('personne/profil_Herberge.html.twig', [
            'personne' => $utilisateur,
            'participation' => $participe2,
            'form2' => $form2,
            'form' => $form,
            'utilisateur' => $utilisateur
        ]);
    }

    
    
}
