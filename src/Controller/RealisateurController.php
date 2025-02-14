<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\RealisateurType;
use App\Repository\RealisateurRepository;
use Doctrine\ORM\EntityManagerInterface;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/realisateur')]
final class RealisateurController extends AbstractController
{
    #[Route('/adminReaisateur',  name: 'app_realisateur_index', methods: ['GET'])]
    public function index(RealisateurRepository $realisateurRepository): Response
    {
        return $this->render('realisateur/index.html.twig', [
            'realisateurs' => $realisateurRepository->findAll(),
        ]);
    }

    #[Route('/ajouterRealisateur', name: 'app_realisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $realisateur = new Realisateur();
        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($realisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('realisateur/new.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form,
        ]);
    }

    #[Route('realisateur/{id}', name: 'app_realisateur_show', methods: ['GET'])]
    public function show(Realisateur $realisateur): Response
    {
        return $this->render('realisateur/show.html.twig', [
            'realisateur' => $realisateur,
        ]);
    }

    #[Route('modifierRealisateur/{id}', name: 'app_realisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Realisateur $realisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('realisateur/edit.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form,
        ]);
    }

    #[Route('/effacerRealisateur/{id}', name: 'app_realisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Realisateur $realisateur, EntityManagerInterface $entityManager): Response
    {
   if ($realisateur->getFilms()->count() < 0) {
        if ($this->isCsrfTokenValid('delete'.$realisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($realisateur);
            $entityManager->flush();
        }
    }
        return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
