<?php

namespace App\GraphQL\Resolver;

use App\Document\Category;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

class CategoryResolver implements ResolverInterface
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

    public function resolve(string $uid): ?Category
    {
        /** @var Category[] $category */
        $category = $this->documentManager
            ->getRepository(Category::class)
            ->findBy(['uid' => $uid]);

        if (!$category || !isset($category[0])) {
            return null;
        }

        return $category[0];
    }

    public function uid(Category $category): string
    {
        return $category->uid;
    }

    public function name(Category $category): string
    {
        return $category->name;
    }

    public function products(Category $category, Argument $args): Connection
    {
        $query = $this->documentManager
            ->getRepository(Product::class)
            ->createQueryBuilder()
            ->field('category')
            ->references($category)
            ->getQuery();
        $products = $query->execute()->toArray();

        $paginator = new Paginator(function ($offset, $limit) use ($products) {
            return array_slice($products, $offset, $limit ?? 10);
        });

        return $paginator->auto($args, count($products));
    }
}
