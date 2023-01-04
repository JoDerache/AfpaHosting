<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Repository\IncidentRepository;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/incident')]
class IncidentController extends AbstractController
{
    #[Route('/', name: 'app_incident_index', methods: ['GET', 'POST'])]
    public function index(Request $request, IncidentRepository $incidentRepository, UserInterface $user, PersonneRepository $personneRepository): Response
    {
        $utilisateur = $personneRepository->findOneBy(['numeroBeneficiaire' => $user->getUserIdentifier()]);
        $incident = new Incident();
        $form = $this->createForm(IncidentType::class, $incident);
        // $form ->setData([['date'=>new \DateTimeImmutable()]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incidentRepository->save($incident, true);

            return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('incident/index.html.twig', [
            'incidents' => $incidentRepository->findAll(),
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_incident_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IncidentRepository $incidentRepository): Response
    {
        $incident = new Incident();
        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incidentRepository->save($incident, true);

            return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('incident/new.html.twig', [
            'incident' => $incident,
            'form' => $form,
        ]);
    }

    #[Route('/{idIncident}', name: 'app_incident_show', methods: ['GET'])]
    public function show(Incident $incident): Response
    {
        return $this->render('incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }

    #[Route('/{idIncident}/edit', name: 'app_incident_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Incident $incident, IncidentRepository $incidentRepository): Response
    {
        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incidentRepository->save($incident, true);

            return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('incident/edit.html.twig', [
            'incident' => $incident,
            'form' => $form,
        ]);
    }

    #[Route('/{idIncident}', name: 'app_incident_delete', methods: ['POST'])]
    public function delete(Request $request, Incident $incident, IncidentRepository $incidentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$incident->getIdIncident(), $request->request->get('_token'))) {
            $incidentRepository->remove($incident, true);
        }

        return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
    }
}
