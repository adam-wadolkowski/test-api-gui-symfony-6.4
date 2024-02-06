<?php

declare(strict_types=1);

namespace App\Dto;

//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PostDto
{
    public function __construct(
        #[Assert\NotBlank(message: "Post title not by blank.")]
        #[Assert\Length(
            min: 10,
            max: 80,
            minMessage: 'Post title must be at least {{ limit }} characters long.',
            maxMessage: 'Post title cannot be longer than {{ limit }} characters',
        )]
        public ?string $title,

        #[Assert\NotBlank(message: "Post content not by blank.")]
        #[Assert\Length(
            min: 20,
            minMessage: 'Post content must be at least {{ limit }} characters long.'
        )]
        public ?string $content,

        #[Assert\NotBlank(message: "Please upload an image jpg mime type.")]
        #[Assert\File(
            maxSize: '1024k',
            mimeTypes: ["image/jpg", "image/jpeg"],
            //mimeTypesMessage: 'Please upload a valid jpg image mime type.'
        )]
        public ?string $image,
        //public UploadedFile $image,
    ) {
    }
}