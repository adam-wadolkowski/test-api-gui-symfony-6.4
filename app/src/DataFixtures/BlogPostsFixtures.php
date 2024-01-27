<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogPostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $postBlog = new Post();
            $postBlog->setTitle($faker->realTextBetween(10, 80))
                ->setContent($faker->realTextBetween(20))
                ->setImage($faker->image(format: 'jpg'));

            $manager->persist($postBlog);
        }

        $manager->flush();
    }
}
