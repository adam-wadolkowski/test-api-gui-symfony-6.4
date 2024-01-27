<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Image;
use App\Service\FileUploader;
//use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ImageUploadListener
{
    public function __construct(public FileUploader $uploader)
    {
    }
//    public function prePersist(LifecycleEventArgs $args): void
//    {
//        //$entity = $args->getEntity();
//        $entity = $args->getObject();
//        $this->uploadFile($entity);
//    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        $this->uploadFile($entity);
    }
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        //$entity = $args->getEntity();
        $entity = $args->getObject();
        $this->uploadFile($entity);
    }
    private function uploadFile($entity): void
    {
        if (!$entity instanceof Image) {
            return;
        }
        $file = $entity->getFile();
        if ($file instanceof UploadedFile) {
            $filename = $this->uploader->upload($file);
            $entity->setFile($filename);
        }
    }
}
