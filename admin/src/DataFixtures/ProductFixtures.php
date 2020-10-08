<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [];
        for ($i = 0; $i <= 1; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setPrice(rand(100, 1000));
            $product->setAuthor($categories[$i % 2 == 0 ? 0 : 1]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
