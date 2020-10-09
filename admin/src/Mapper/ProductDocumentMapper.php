<?php

namespace App\Mapper;

use App\Document\Category as CategoryDocument;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use App\Entity\Product as ProductEntity;
use App\Document\Product as ProductDocument;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductDocumentMapper implements AutoMapperConfiguratorInterface
{
    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(ProductEntity::class, ProductDocument::class)
            ->forMember('id', function () {
                return null;
            })
            ->forMember('category', function (ProductEntity $source) {
                $category = $this->documentManager
                    ->getRepository(CategoryDocument::class)
                    ->findBy(['uid' => $source->getCategory()->getUid()]);

                if (!$category || !isset($category[0])) {
                    return null;
                }

                return $category[0];
            });
    }
}
