<?php

namespace App\Controller;

use DateTime;
use App\Entity\Bail;
use DateTimeImmutable;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Form\ModifierBailType;
use App\Form\AttribuerChambreType;
use App\Repository\BailRepository;
use App\Repository\ChambreRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/chambre')]
class ChambreController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/', name: 'app_chambre_index')]
    public function index(ManagerRegistry $doctrine,BailRepository $bailRepository, ChambreRepository $chambreRepository, UserInterface $user, PersonneRepository $personneRepository,Request $request): Response
    {
        
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        
        // Requête permettant de récupérer toutes les chambres ET d'y ajouté les bails correspondant 
        $chambres = $doctrine->getConnection();
        $sql = '
        SELECT DISTINCT c.*, b.id_personne,b.date_entree,b.date_sortie, p.prenom, p.nom
        FROM `chambre` as c 
        left join bail as b ON c.numero_chambre = b.numero_chambre AND ((b.date_sortie >"'.$date.'" AND b.date_entree <"'.$date.'")
        OR (b.date_sortie >"'.$date.'" AND b.date_entree >"'.$date.'")
        )
        left join personne as p ON b.id_personne = p.id_personne 
        ';
        $stmt = $chambres->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $allChambres = ($resultSet->fetchAll());
        $chambreMax = $chambreRepository->findAll();
        $bails = $bailRepository->findAll();
        $bailEnCours = 0;
        $chambreReserve = 0;
        $chambreInutilisable = $chambreRepository->findBy(['status' => ['local technique', 'néant']]);
        $chambreInutilisable = count($chambreInutilisable);

        foreach($bails as $bail){
                if (($bail->getDateEntree()->format('Y-m-d') < $date) && ($bail->getDateSortie()->format('Y-m-d') > $date))
                    $bailEnCours = $bailEnCours + 1;
                $this->entityManager->flush();
                if (($bail->getDateEntree()->format('Y-m-d') > $date)){
                    $chambreReserve = $chambreReserve + 1;
                }
                }

        $chambreLibre = count($chambreMax) - $bailEnCours - $chambreInutilisable;
        $chambreOccupe = count($chambreMax) - $chambreLibre - $chambreInutilisable;


        // FORMULAIRE ATTRIBUTION DE CHAMBRE
        $bail = new Bail();
        $chambre = $chambreRepository->findOneBy(['numeroChambre' => '501']);
        $form = $this->createForm(AttribuerChambreType::class, ['bail' => $bail, 'chambre' => $chambre]);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                
                $this->entityManager->persist($bail);
                $this->entityManager->persist($chambre);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_chambre_index', [
                    'chambres' => $allChambres,
                    'utilisateur' => $utilisateur,
                    'chambreLibre' => $chambreLibre,
                    'chambreOccupe' => $chambreOccupe,
                    'chambreReserve' => $chambreReserve,
                    'chambreCondamne' => $chambreInutilisable,
                    'form' => $form,
                ]);
            }

        return $this->renderForm('chambre/index.html.twig', [
            'chambres' => $allChambres,
            'utilisateur' => $utilisateur,
            'chambreLibre' => $chambreLibre,
            'chambreOccupe' => $chambreOccupe,
            'chambreReserve' => $chambreReserve,
            'chambreCondamne' => $chambreInutilisable,
            'form' => $form,
        ]);
    }


    #[Route('/new', name: 'app_chambre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChambreRepository $chambreRepository): Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chambreRepository->save($chambre, true);

            return $this->redirectToRoute('app_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chambre/new.html.twig', [
            'chambre' => $chambre,
            'form' => $form,
        ]);
    }

    #[Route('/{numeroChambre}', name: 'app_chambre_show', methods: ['GET'])]
    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    #[Route('/{numeroChambre}/edit', name: 'app_chambre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chambre $chambre, ChambreRepository $chambreRepository): Response
    {   
        $bail = new Bail();
        $form = $this->createForm(AttribuerChambreType::class, ['bail' => $bail, 'chambre' => $chambre]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chambreRepository->save($chambre, true);

            return $this->redirectToRoute('app_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form,
        ]);
    }

    #[Route('/{numeroChambre}', name: 'app_chambre_delete', methods: ['POST'])]
    public function delete(Request $request, Chambre $chambre, ChambreRepository $chambreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chambre->getNumeroChambre(), $request->request->get('_token'))) {
            $chambreRepository->remove($chambre, true);
        }

        return $this->redirectToRoute('app_chambre_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/attribuer/{numeroChambre}', name: 'attribuer')]
    public function attribuer($numeroChambre,BailRepository $bailRepository, ChambreRepository $chambreRepository, Request $request): Response
    {
               // FORMULAIRE ATTRIBUTION DE CHAMBRE
        $date = new DateTimeImmutable;
        $bail = new Bail();
        $chambre = $chambreRepository->findOneBy(['numeroChambre' => $numeroChambre]);
        $compteurError = 0;

        $form = $this->createForm(AttribuerChambreType::class, ['bail' => $bail, 'chambre' => $chambre]);
        $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $bail->setNumeroChambre($chambre);
                if($bail->getDateEntree() > $date){
                    $chambre->setStatus('Réservée');
                }
                if($bail->getDateEntree() < $date && $bail->getDateSortie() > $date){
                    $chambre->setStatus('Occupée');
                }
                $this->entityManager->persist($bail);

                $bails = $bailRepository->findBy(['numeroChambre' => $bail->getNumeroChambre()]);
                foreach($bails as $b){
                    if (($b->getDateEntree() < $bail->getDateEntree()) && ($b->getDateSortie() > $bail->getDateEntree())
                    || ($b->getDateEntree() < $bail->getDateSortie()) && ($b->getDateSortie() > $bail->getDateSortie())
                    || ($b->getDateEntree() > $bail->getDateEntree()) && ($b->getDateSortie() < $bail->getDateSortie())
                    ){
                        $compteurError = $compteurError +1;
                    }
                }
                if($compteurError > 0){
                    $this->addFlash('error', 'Il y a déjà un hébergé dans cette chambre pour la période choisie, celui-ci n\'a donc pas été ajouté !');
                    return $this->redirectToRoute('app_chambre_index');
                }
                else {
                    $this->entityManager->persist($chambre);
                    $this->entityManager->flush();
                    return $this->redirectToRoute('app_chambre_index');
                }
            }
            return $this->renderForm('chambre/index.html.twig');
    }



    #[Route('/modifier/{numeroChambre}', name: 'modifier')]
    public function modifier($numeroChambre, ChambreRepository $chambreRepository, BailRepository $bailRepository, Request $request): Response
    {

    $chambre = $chambreRepository->findOneBy(['numeroChambre' => $numeroChambre]);
    $date = new DateTimeImmutable;
    $bails = $bailRepository->findBy(['numeroChambre' => $numeroChambre]);
    // FORMULAIRE MODIFICATION DE CHAMBRE
    $dateEntree = new DateTimeImmutable($_POST['date_entree']);
    $dateSortie = new DateTimeImmutable($_POST['date_sortie']);

    foreach($bails as $bail){
        if($bail->getDateSortie() > $date){

            $bail->setDateEntree($dateEntree);
            $bail->setDateSortie($dateSortie);
            $this->entityManager->persist($bail);
            $this->entityManager->flush();
        };
    }
    return $this->redirectToRoute('app_chambre_index', [
    ]);
    }

}
