<?php

namespace App\Command;

use App\Document\Category;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct();

        $this->documentManager = $documentManager;
    }

    protected function configure()
    {
        $this->setDescription('Test command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Testing...');

        $io->writeln('Categories');
        $table = new Table($output);
        $table->setHeaders(['ID', 'UID', 'Name']);
        $categories = $this->documentManager->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $table->addRow([$category->id, $category->uid, $category->name]);
        }
        $table->render();

        $io->writeln('Products');
        $table = new Table($output);
        $table->setHeaders(['ID', 'UID', 'Name', 'Price', 'Category']);
        $products = $this->documentManager->getRepository(Product::class)->findAll();
        foreach ($products as $product) {
            $table->addRow([$product->id, $product->uid, $product->name, $product->price, $product->category->name]);
        }
        $table->render();

        $io->success('Done!');

        return Command::SUCCESS;
    }
}
