<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'post:add',
    description: 'Add one post in cli',
)]
class AddPostCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Title of a post')
            ->addArgument('content', InputArgument::REQUIRED, 'Content of a post')
            ->addArgument('image', InputArgument::REQUIRED, 'Image of a post')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $title = $input->getArgument('title');
        $content = $input->getArgument('content');
        $image = $input->getArgument('image');

        if ($title) {
            $io->note(sprintf('Title: %s', $title));
        }

        if ($content) {
            $io->note(sprintf('Content: %s', $content));
        }

        if ($image) {
            $io->note(sprintf('Image: %s', $image));
        }

        $post = new Post();
        $post->setTitle($title)
            ->setContent($content)
            ->setImage($image);

        $this->em->persist($post);
        $this->em->flush();

        $io->success(sprintf('Post id: %s is saved.', $post->getId()));

        return Command::SUCCESS;
    }
}
