<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;

#[AsDoctrineListener('prePersist'/*, 500, 'default'*/)]
class PrePersistEntityListener
{
    private const ALLOWED_TAGS = '<ul><li><ol><p><strong>';

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Post) {
            return;
        }

        $entity->setTitle($this->stripTags($entity->getTitle()));
        $entity->setContent($this->stripTags($entity->getContent()));
    }

    private function stripTags(string $data): string
    {
        return strip_tags($data, self::ALLOWED_TAGS);
    }
}
