<?php

namespace App\GraphQL\Resolver;

use App\Document\Category;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ProductResolver implements ResolverInterface
{
    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function __invoke(ResolveInfo $info, $value, Argument $args)
    {
        $method = $info->fieldName;
        return $this->$method($value, $args);
    }

    public function resolve(string $uid): ?Product
    {
        /** @var Product[] $product */
        $product = $this->documentManager
            ->getRepository(Product::class)
            ->findBy(['uid' => $uid]);

        if (!$product || !isset($product[0])) {
            return null;
        }

        return $product[0];
    }

    public function uid(Product $product): string
    {
        return $product->uid;
    }

    public function name(Product $product): string
    {
        return $product->name;
    }

    public function price(Product $product): int
    {
        return $product->price;
    }

    public function category(Product $product): Category
    {
        return $product->category;
    }
}
