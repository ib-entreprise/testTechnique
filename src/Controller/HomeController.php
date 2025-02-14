<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
    use App\Repository\FilmRepository;

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

   
    
}
