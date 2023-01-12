<?php

namespace App\Controller;

use DateTime;
use App\Entity\Bail;
use DateTimeImmutable;
use App\Entity\Chambre;
use App\Entity\Travaux;
use App\Form\ChambreType;
use App\Form\TravauxType;
use App\Form\ModifierBailType;
use App\Form\AttribuerChambreType;
use App\Repository\BailRepository;
use App\Repository\ChambreRepository;
use App\Repository\TravauxRepository;
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
    public function index(ManagerRegistry $doctrine, TravauxRepository $travauxRepository, BailRepository $bailRepository, ChambreRepository $chambreRepository, UserInterface $user, PersonneRepository $personneRepository, Request $request): Response
    {

        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        $travauxListes = $travauxRepository->findAll();
        // Requête permettant de récupérer toutes les chambres ET d'y ajouté les bails correspondant 
        $chambres = $doctrine->getConnection();

        $sql = '
        SELECT c.numero_chambre,c.numero_etage,c.numero_clefs,c.etat,
        id_bail,b.id_personne,b.date_entree,b.date_sortie,b.status,
        p.prenom, p.nom,
        t.id_travaux,tt.nom_travaux,t.date_debut,t.date_fin,t.commentaire_travaux
        FROM `chambre` as c 
        left join bail as b ON c.numero_chambre = b.numero_chambre AND ((b.date_sortie >"' . $date . '" AND b.date_entree <"' . $date . '")
        OR (b.date_sortie >"' . $date . '" AND b.date_entree >"' . $date . '")
        )
        left join personne as p ON b.id_personne = p.id_personne
        left join travaux as t on c.numero_chambre = t.numero_chambre
        left join type_travaux as tt on t.id_travaux_type_travaux = tt.id_travaux
        order by c.numero_chambre ASC, t.date_fin DESC
        ';
        $stmt = $chambres->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $allChambres = ($resultSet->fetchAll());
        $chambreMax = count($chambreRepository->findAll());
        $goodChambres = [];
        for ($i = 0; $i < count($allChambres); $i++) {
            $numeroChambre = $allChambres[$i]['numero_chambre'];
            if ($i > 0) {
                if ($allChambres[$i - 1]['numero_chambre'] == $numeroChambre) {
                    if ($goodChambres[$numeroChambre]['date_entree'] > $allChambres[$i]['date_entree']) {
                        $goodChambres[$numeroChambre] = $allChambres[$i];
                    }
                } else {
                    $goodChambres[$numeroChambre] = $allChambres[$i];
                }
            } else {
                $goodChambres[$numeroChambre] = $allChambres[$i];
            }
        }


        $tab = [];
        $allTravaux = $travauxRepository->findAll();
        if (!empty($allTravaux)) {
            foreach ($travauxRepository->findAll() as $t) {
                if (($t->getDateDebut()->format('Y-m-d') <= $date
                    && $t->getDateFin()->format('Y-m-d') > $date)) {
                    array_push($tab, $t);
                    $numCh = $t->getNumeroChambre()->getNumeroChambre();
                    if (isset($goodChambres[$numCh])) {
                        $goodChambres[$numCh]['etat'] = "En travaux";
                    }
                } else {
                }
            }
            $this->entityManager->persist($t);
        }

        $bails = $bailRepository->findAll();
        $bailEnCours = 0;
        $chambreReserve = 0;
        $chambreInutilisable = $bailRepository->findBy(['status' => ['local technique', 'néant']]);
        $chambreInutilisable = count($chambreInutilisable);

        if ($bails) {
            foreach ($bails as $bail) {
                if (($bail->getDateEntree()->format('Y-m-d') < $date) && ($bail->getDateSortie()->format('Y-m-d') > $date)) {
                    $bailEnCours = $bailEnCours + 1;
                    $bail->setStatus('Occupé');
                    $this->entityManager->flush();
                } elseif (($bail->getDateEntree()->format('Y-m-d') > $date)) {
                    $chambreReserve = $chambreReserve + 1;
                    $bail->setStatus('Réservé');
                } else {
                    $bail->setStatus('Libre');
                }
            }

            $this->entityManager->persist($bail);
        }

        $this->entityManager->flush();

        $chambreLibre = $chambreMax - $bailEnCours - $chambreInutilisable;
        $chambreOccupe = $chambreMax - $chambreLibre - $chambreInutilisable;

        $pourcentChambrelibre = ($chambreLibre * 100) / $chambreMax;
        $pourcentChambreOccupe = ($chambreOccupe * 100) / $chambreMax;
        $pourcentChambreReserve = ($chambreReserve * 100) / $chambreMax;
        $pourcentChambreInutilisable = ($chambreInutilisable * 100) / $chambreMax;


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
                'chambres' => $goodChambres,
                'pourcentLibre' => $pourcentChambrelibre,
                'pourcentOccupe' => $pourcentChambreOccupe,
                'pourcentReserve' => $pourcentChambreReserve,
                'pourcentInutilisable' => $pourcentChambreInutilisable,
                'utilisateur' => $utilisateur,
                'chambreLibre' => $chambreLibre,
                'chambreOccupe' => $chambreOccupe,
                'chambreReserve' => $chambreReserve,
                'chambreCondamne' => $chambreInutilisable,
                'form' => $form,
                'formTravaux' => $formTravaux,
                'travaux' => $travauxListes
            ]);
        }

        // FORMULAIRE DE TRAVAUX DE CHAMBRE 
        $travaux = new Travaux();
        $formTravaux = $this->createForm(TravauxType::class, $travaux);
        $formTravaux->handleRequest($request);
        if ($formTravaux->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($travaux);
            $this->entityManager->flush();
        };
        return $this->renderForm('chambre/index.html.twig', [
            'chambres' => $goodChambres,
            'pourcentLibre' => $pourcentChambrelibre,
            'pourcentOccupe' => $pourcentChambreOccupe,
            'pourcentReserve' => $pourcentChambreReserve,
            'pourcentInutilisable' => $pourcentChambreInutilisable,
            'utilisateur' => $utilisateur,
            'chambreLibre' => $chambreLibre,
            'chambreOccupe' => $chambreOccupe,
            'chambreReserve' => $chambreReserve,
            'chambreCondamne' => $chambreInutilisable,
            'form' => $form,
            'formTravaux' => $formTravaux,
            'travaux' => $travauxListes
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
        if ($this->isCsrfTokenValid('delete' . $chambre->getNumeroChambre(), $request->request->get('_token'))) {
            $chambreRepository->remove($chambre, true);
        }

        return $this->redirectToRoute('app_chambre_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/attribuer/{numeroChambre}', name: 'attribuer')]
    public function attribuer($numeroChambre, BailRepository $bailRepository, ChambreRepository $chambreRepository, Request $request): Response
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
            if ($bail->getDateEntree() > $date) {
                $bail->setStatus('Réservé');
            }
            if ($form->getData()['bail']->getDateEntree() < $date && $form->getData()['bail']->getDateSortie() > $date) {
                $bail->setStatus('Occupé');
            }
            if ($form->getData()['bail']->getDateEntree() < $date && $form->getData()['bail']->getDateSortie() < $date) {
                $bail->setStatus('Libre');
            }
            $this->entityManager->persist($bail);

            $bails = $bailRepository->findBy(['numeroChambre' => $bail->getNumeroChambre()]);
            foreach ($bails as $b) {
                if (($b->getDateEntree() < $bail->getDateEntree()) && ($b->getDateSortie() > $bail->getDateEntree())
                    || ($b->getDateEntree() < $bail->getDateSortie()) && ($b->getDateSortie() > $bail->getDateSortie())
                    || ($b->getDateEntree() > $bail->getDateEntree()) && ($b->getDateSortie() < $bail->getDateSortie())
                ) {
                    $compteurError = $compteurError + 1;
                }
            }
            if ($compteurError > 0) {
                $this->addFlash('error', 'Il y a déjà un hébergé dans cette chambre pour la période choisie, celui-ci n\'a donc pas été ajouté !');
                return $this->redirectToRoute('app_chambre_index');
            } else {
                $this->entityManager->persist($chambre);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_chambre_index');
            }
        }
        return $this->redirectToRoute('app_chambre_index');
    }


    #[Route('/modifier/{numeroBail}', name: 'modifier')]
    public function modifier($numeroBail, ChambreRepository $chambreRepository, BailRepository $bailRepository, Request $request): Response
    {
        // $chambre = $chambreRepository->findOneBy(['numeroChambre' => $numeroChambre]);
        $date = new DateTimeImmutable;
        $bail = $bailRepository->findBy(['idBail' => $numeroBail]);
        // FORMULAIRE MODIFICATION DE CHAMBRE
        $dateEntree = new DateTimeImmutable($request->get('date_entree'));
        $dateSortie = new DateTimeImmutable($request->get('date_sortie'));
        if (current($bail)->getDateSortie() > $date) {
            current($bail)->setDateEntree($dateEntree);
            current($bail)->setDateSortie($dateSortie);
            $this->entityManager->persist(current($bail));
            $this->entityManager->flush();
        };
        return $this->redirectToRoute('app_chambre_index', [
        ]);
    }

    #[Route('/travaux/{numeroChambre}', name: 'travaux')]
    public function travaux($numeroChambre, ChambreRepository $chambreRepository, BailRepository $bailRepository, Request $request): Response
    {
        $chambre = $chambreRepository->findOneBy(['numeroChambre' => $numeroChambre]);
        $date = new DateTimeImmutable;

        $travaux = new Travaux();
        $formTravaux = $this->createForm(TravauxType::class, $travaux);
        $formTravaux->handleRequest($request);
        if ($formTravaux->isSubmitted() && $formTravaux->isValid()) {
            $travaux->setNumeroCHambre($chambre);
            if ($travaux->getDateDebut() <= $date) {
                $chambre->setEtat('En travaux');
            }

            $this->entityManager->persist($travaux);
            $this->entityManager->flush();
        };
        return $this->redirectToRoute('app_chambre_index', [
        ]);
    }


}
