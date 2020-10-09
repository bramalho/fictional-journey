<?php

namespace App\GraphQL\Resolver;

use App\Document\Category;
use Doctrine\ODM\MongoDB\DocumentManager;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;

class CategoryListResolver implements ResolverInterface
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
        $categories = $this->documentManager->getRepository(Category::class)->findBy(
            [], ['name' => 'asc'], $args['limit'], 0
        );

        return ['categories' => $categories];
    }
}
