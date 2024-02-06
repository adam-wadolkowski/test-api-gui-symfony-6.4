<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle($faker->realTextBetween(10, 80))
                ->setContent($faker->realTextBetween(20))
                ->setImage($faker->image(format: 'jpg'));

            $manager->persist($post);
        }

        $manager->flush();
    }
}
