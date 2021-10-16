<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // Créer 3 catégories fakées
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();

            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            // Créer entre 4 et 6 articles
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {

                $article = new Article();

                $article->setTitle($faker->sentence())
                    ->setContent("<p>Contenu de l'article n°$j</p>")
                    ->setImage("https://images.gameinfo.io/pokemon/256/094-00.png")
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($article);

                // On donne des commentaires à l'article
                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                    $comment->setAuthor($faker->name)
                        ->setContent("<p>Contenu de l'article n°$j</p>")
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
