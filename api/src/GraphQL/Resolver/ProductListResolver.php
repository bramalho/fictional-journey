<?php

namespace App\GraphQL\Resolver;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ProductListResolver implements ResolverInterface
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

    public function resolve(Argument $args)
    {
        $products = $this->documentManager->getRepository(Product::class)->findBy(
            [], ['name' => 'asc'], $args['limit'], 0
        );

        return ['products' => $products];
    }
}
