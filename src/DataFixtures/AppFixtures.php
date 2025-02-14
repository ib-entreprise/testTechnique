<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Realisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeImmutable;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        
        $realisateur1 = new Realisateur();        
        $realisateur1->setNom($faker->lastName());
        $manager->persist($realisateur1);

        $realisateur2 = new Realisateur();
        $realisateur2->setNom($faker->lastName());
        $manager->persist($realisateur2);

         
        $genre1 = new Genre();
        $genre1->setNom('Action');
        $manager->persist($genre1);

        $genre2 = new Genre();
        $genre2->setNom('Comédie');
        $manager->persist($genre2);

         
        $film1 = new Film();
        $film1->setTitre($faker->sentence(3))
            ->setAnneeSortie($faker->year())
            ->setSynopsis($faker->paragraph())
            ->setRealisateur($realisateur1)
            ->setImage($faker->imageUrl())
            ->addGenre($genre1)
            ->addGenre($genre2)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable())
            ;
        $manager->persist($film1);

        $film2 = new Film();
        $film2->setTitre($faker->sentence(3))
            ->setAnneeSortie($faker->year())
            ->setSynopsis($faker->paragraph())
            ->setRealisateur($realisateur2)
            ->setImage($faker->imageUrl())
            ->addGenre($genre1)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable())
            ;
        $manager->persist($film2);
        $manager->flush();
    }
}
