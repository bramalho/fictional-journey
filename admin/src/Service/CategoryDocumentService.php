<?php

namespace App\Service;

use App\Entity\Category as CategoryEntity;
use App\Document\Category as CategoryDocument;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

class CategoryDocumentService
{
    /** @var DocumentManager */
    private $documentManager;

    /** @var AutoMapperInterface */
    private $mapper;

    public function __construct(DocumentManager $documentManager, AutoMapperInterface $mapper)
    {
        $this->documentManager = $documentManager;
        $this->mapper = $mapper;
    }

    public function saveCategoryDocument(CategoryEntity $categoryEntity)
    {
        $categoryDocument = $this->mapper->map($categoryEntity, CategoryDocument::class);

        $existingDocument = $this->documentManager
            ->getRepository(CategoryDocument::class)
            ->findBy(['uid' => $categoryEntity->getUid()]);

        if (isset($existingDocument[0])) {
            $categoryDocument->id = $existingDocument[0]->id;
        }

        $this->documentManager->persist($categoryDocument);

        $this->documentManager->flush();
    }
}
