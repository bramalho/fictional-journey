<?php

namespace App\Mapper;

use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use App\Entity\Category as CategoryEntity;
use App\Document\Category as CategoryDocument;

class CategoryDocumentMapper implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(CategoryEntity::class, CategoryDocument::class)
            ->forMember('id', function () {
                return null;
            });
    }
}
