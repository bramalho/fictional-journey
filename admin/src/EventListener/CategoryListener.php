<?php

namespace App\EventListener;

use App\Entity\Category;
use App\Service\CategoryDocumentService;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryListener implements EventSubscriberInterface
{
    /** @var CategoryDocumentService */
    private $categoryDocumentService;

    public function __construct(CategoryDocumentService $categoryDocumentService)
    {
        $this->categoryDocumentService = $categoryDocumentService;
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

        if (!$entity instanceof Category) {
            return;
        }

        $entity->setUid(Uuid::uuid4()->toString());
    }

    public function postPersist(AfterEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Category) {
            return;
        }

        $this->categoryDocumentService->saveCategoryDocument($entity);
    }

    public function postUpdate(AfterEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Category) {
            return;
        }

        $this->categoryDocumentService->saveCategoryDocument($entity);
    }
}
