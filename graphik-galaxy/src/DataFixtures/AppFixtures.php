<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $categories = ['Mangas', 'Comics', 'Goodies'];
        $genres = ['Action', 'Fantasy', 'Horreur', 'Science-Fiction', 'Romance'];
        $public = ['enfant', 'adolescent', 'adultes'];


        for ($i = 0; $i < 25; $i++) {
            $product = new Products;
            $product->setNom($faker->name())->setPrix($faker->randomFloat(2, 0, 1000))->setPublicCible($faker->randomElement($public))->setCategorie($faker->randomElement($categories))->setGenre($faker->randomElement($genres))->setTaille($faker->randomNumber(3))->setImages($faker->imageUrl(640, 480, 'mangas', true, 'shonen'));
            $user = new User;
            $user->setEmail($faker->email)->setFirstname($faker->firstName)->setLastname($faker->lastName)->setPassword($faker->password)->setUsername($faker->userName);
            $manager->persist($product);
        }


        $manager->flush();
    }
}
