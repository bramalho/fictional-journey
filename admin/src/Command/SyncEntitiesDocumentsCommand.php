<?php

namespace App\Command;

use App\Entity\Category;
use App\Service\CategoryDocumentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncEntitiesDocumentsCommand extends Command
{
    protected static $defaultName = 'app:sync:entities-documents';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CategoryDocumentService */
    private $categoryDocumentService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryDocumentService $categoryDocumentService
    ) {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->categoryDocumentService = $categoryDocumentService;
    }

    protected function configure()
    {
        $this->setDescription('Sync all Entities to Documents');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Sync all Entities to Documents');

        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        /** @var Category $category */
        foreach ($categories as $category) {
            $io->writeln('Sync Category #' . $category->getId() . ' ' . $category->getName());
            $this->categoryDocumentService->saveCategoryDocument($category);
        }

        $io->success('Done');

        return Command::SUCCESS;
    }
}
