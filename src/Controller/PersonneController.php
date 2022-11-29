<?php

namespace App\Controller;

use App\Entity\Bail;
use App\Entity\Login;
use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\UpdatePasswordType;
use App\Form\UserFormType;
use App\Form\UpdatePersonneType;
use App\Repository\BailRepository;
use App\Repository\LoginRepository;
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

#[Route('/personne')]
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
            'utilisateur' => $utilisateur,
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route('/byBail', name: 'app_personne_indexByBail', methods: ['GET'])]
    public function indexByBail(PersonneRepository $personneRepository, BailRepository $bailRepository, UserInterface $user): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);

        return $this->render('personne/indexByBail.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'bails' => $bailRepository->findAll(),
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/{idPersonne}', name: 'app_personne_show', methods: ['GET'])]
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/{id}', name: 'app_personne_show', methods: ['GET', 'POST'])]
    public function showStudent(Personne $personne, PersonneRepository $personneRepository, ParticipationRepository $participationRepository, Request $request, EntityManagerInterface $manager): Response

    {
        // ##########Pour la mise à jours des information deprofil#####
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);

        $participe = $participationRepository->findBy(['idPersonne'=>$personne->getIdPersonne()]);
        $participe2=end($participe);

        $form = $this->createForm(UpdatePersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->save($personne, true);

            return $this->renderForm('personne/profil_Herberge.html.twig', [
                'personne' => $personne,
                'participation' => $participe2,
                'form' => $form,
                'utilisateur'=>$utilisateur
            ]);
        }

        // #########Pour l'édition du mot de passe###########
        // dd($personne);
        $idlogin = $personne->getIdLogin();
        $loginUser = $loginRepository ->find($idlogin);
        $login = $loginUser;

        $user = array('oldMdpEmp' => '', 'mdpEmp' => '');
        $form2 = $this->createFormBuilder($user)
        ->add('oldMdpEmp', PasswordType::class, ['attr' => ['class' => 'form-control'] , 'label' => 'Mot de passe actuel'])
        ->add('mdpEmp', RepeatedType::class, [
            'type'=> PasswordType::class,
            'first_options' => array('label' => 'Mot de passe'),
            'second_options' => array('label'=> 'Confirmez le mot de passe'),
            'invalid_message' => 'Les deux mots de passe doivent correspondre',
            'options' => ['attr' => ['class' => 'form-control']],
            ]) 
        ->add('submit', SubmitType::class, ['attr' => ['id' => 'bouton', 'class' => 'btn btn-danger card-btn'], 'label' => 'Changer le mot de passe'])
        ->getForm();




        // $form2=$this->createForm(UpdatePasswordType::class, $loginUser);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $data = $form2->getData();
            // dd($hasher->isPasswordValid($login,$data['oldMdpEmp']));
            if ($hasher->isPasswordValid($login,$data['oldMdpEmp'])) {
                $hash = $hasher->hashPassword($loginUser, $data['mdpEmp']);
                $loginUser ->setMdp($hash);
                $manager->persist($loginUser);
                $manager->flush();
                // $loginRepository->save($loginUser, true);
                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );
                return $this->renderForm('personne/profil_Herberge.html.twig', [
                    'personne' => $personne,
                    'participation' => $participe2,
                    'form2' => $form2,
                    'form' => $form,
                    'utilisateur'=>$utilisateur
                ]);
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
                
            }
            // return $this->redirectToRoute('app_financeur_index', [], Response::HTTP_SEE_OTHER);
        
        }
        return $this->renderForm('personne/profil_Herberge.html.twig', [
            'personne' => $personne,
            'participation' => $participe2,
            'form' => $form
        ]);
    }               

    // #[Route('/{idPersonne}/newPW', name: 'app_personne_edit', methods: ['GET', 'POST'])]
    // public function editPW(Personne $personne, PersonneRepository $personneRepository, EntityManagerInterface $manager, LoginRepository $loginRepository, Request $request, UserPasswordHasherInterface $hasher, ParticipationRepository $participationRepository ): Response
    // {
    //     // dd($personne);
    //     $idlogin = $personne->getIdLogin();
    //     $loginUser = $loginRepository ->find($idlogin);

    //     $form=$this->createForm(UpdatePasswordType::class, $loginUser);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($hasher->isPasswordValid($loginUser, $form->getData()->getPassword())) {
    //             // $user = $form->getData();
    //             // $manager->persist($user);
    //             // $manager->flush();
    //             $loginRepository->save($loginUser, true);
    //             $this->addFlash(
    //                 'success',
    //                 'Les informations de votre compte ont bien été modifiées.'
    //             );

    //             return $this->redirect('/personne/495/');
    //         } else {
    //             $this->addFlash(
    //                 'warning',
    //                 'Le mot de passe renseigné est incorrect.'
    //             );
    //         }

    //         return $this->redirect('/personne/495/');
    //     }
    //         return $this->renderForm('personne/testUpdatePassword.html.twig', [
    //             'personne' => $personne,
    //             'form' => $form
    //         ]);
    // }





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
        if ($this->isCsrfTokenValid('delete' . $personne->getIdPersonne(), $request->request->get('_token'))) {
            $personneRepository->remove($personne, true);
        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }
}
