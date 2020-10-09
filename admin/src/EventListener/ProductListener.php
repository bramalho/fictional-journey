<?php

namespace App\EventListener;

use App\Entity\Product;
use App\Service\ProductDocumentService;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductListener implements EventSubscriberInterface
{
    /** @var ProductDocumentService */
    private $productDocumentService;

    public function __construct(ProductDocumentService $productDocumentService)
    {
        $this->productDocumentService = $productDocumentService;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['prePersist'],
            AfterEntityPersistedEvent::class => ['postPersist'],
            AfterEntityUpdatedEvent::class => ['postUpdate']
        ];
    }

    public function prePersist(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Product) {
            return;
        }

        $entity->setUid(Uuid::uuid4()->toString());
    }

    public function postPersist(AfterEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Product) {
            return;
        }

        $this->productDocumentService->saveProductDocument($entity);
    }

    public function postUpdate(AfterEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Product) {
            return;
        }

        $this->productDocumentService->saveProductDocument($entity);
    }
}
