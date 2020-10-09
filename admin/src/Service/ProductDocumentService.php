<?php

namespace App\Service;

use App\Entity\Product as ProductEntity;
use App\Document\Product as ProductDocument;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductDocumentService
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

    public function saveProductDocument(ProductEntity $productEntity)
    {
        $productDocument = $this->mapper->map($productEntity, ProductDocument::class);

        $existingDocument = $this->documentManager
            ->getRepository(ProductDocument::class)
            ->findBy(['uid' => $productEntity->getUid()]);

        if (isset($existingDocument[0])) {
            $productDocument->id = $existingDocument[0]->id;
        }

        $this->documentManager->persist($productDocument);

        $this->documentManager->flush();
    }
}
