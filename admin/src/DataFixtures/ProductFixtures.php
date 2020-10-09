<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [];
        for ($i = 0; $i <= 1; $i++) {
            $category = new Category();
            $category->setUid(Uuid::uuid4()->toString());
            $category->setName('Category ' . $i);
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setUid(Uuid::uuid4()->toString());
            $product->setName('Product ' . $i);
            $product->setPrice(rand(100, 1000));
            $product->setCategory($categories[$i % 2 == 0 ? 0 : 1]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
