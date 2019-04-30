<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        require_once '/var/www/symfony/demo/vendor/fzaninotto/faker/src/autoload.php';
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();

        for($i = 0; $i < 3; $i++ ){
            $caterogy = new Category();
            $caterogy->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());
            $manager->persist($caterogy);

            for ($j = 0; $j < mt_rand(4,6) ; $j++)
            {

                $content = '<p>'. join($faker->paragraphs(5),'</p><p>') .'</p>';

                $article = new Article();
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($caterogy);

                //enregistrer la doctrine
                $manager->persist($article);

                for ($k = 0; $k < mt_rand(4,10) ; $k++){
                    $comment = new Comment();
                    $content = '<p>'. join($faker->paragraphs(2),'</p><p>') .'</p>';

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt(new \DateTime())
                            ->setArticle($article) ;
                    $manager->persist($comment);
                }
            }
        }

        //mise à jour la base
        $manager->flush();
    }
}
