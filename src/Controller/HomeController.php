<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
    use App\Repository\FilmRepository;
    use Symfony\Component\HttpFoundation\Request;
    use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;



final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {
        $lastFilms = $filmRepository->findBy(
        [],
        ['createdAt' => 'DESC'],  
        5
        );

        return $this->render('home/index.html.twig', [
            'lastFilms' => $lastFilms,
        ]);
    }
  
     #[Route('/api-film/{id}', name: 'app_api_film')]
    public function api($id,FilmRepository $filmRepository): Response
    {
        $film = $filmRepository->find($id);
          if (!$film) {
            return new JsonResponse (['error' => 'Film not found'], Response::HTTP_NOT_FOUND);
        }
              
        return new JsonResponse([
            'id' => $film->getId(),
            'title' => $film->getTitle(),
            'release_date' => $film->getReleaseDate()->format('Y-m-d'),
            'description' => $film->getDescription()            
        ]);
    }
      #[Route('/recherche/film', name: 'app_api_search')]
    public function search(Request $request,EntityManagerInterface $em ): Response
    {
      
        if ($request->isMethod('POST')) {
            $query = $request->request->get('query'); 

            if ($query) {
                
                $films = $em->getRepository(Film::class)
                    ->createQueryBuilder('f')
                    ->where('f.titre LIKE :query or f.Synopsis LIKE :query')
                    ->setParameter('query', '%' . $query . '%')
                    ->getQuery()
                    ->getResult();
                    // dd($films);
            } else {
                $films = [];
            }
        } else {
            
            return $this->redirectToRoute('app_home'); 
        }

    
        return $this->render('home/search.html.twig', [
            'films' => $films,
            'query' => $query
        ]);
    }
    
}
