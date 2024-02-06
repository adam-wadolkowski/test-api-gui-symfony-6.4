<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileUploaderService
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger)
    {
    }

//    public function upload(UploadedFile $file)
//    {
//        $filename = md5(uniqid()) . '.' . $file->guessExtension();
//        $file->move($this->targetDirectory, $filename);
//        return $filename;
//    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {

        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
