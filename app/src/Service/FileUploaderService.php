<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class FileUploaderService
{
    public function __construct(private string $targetDirectory)
    {
    }

    public function upload(UploadedFile $file)
    {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->targetDirectory, $filename);
        return $filename;
    }
}