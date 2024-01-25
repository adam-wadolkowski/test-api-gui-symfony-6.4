<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
//use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

//    #[ORM\Id]
//    #[ORM\Column(type: Types::GUID, unique: true)]
//    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
//    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
//    private ?int $id = null;

//    #[ORM\Column(type: Types::GUID, unique: true)]
//#    #[ORM\GeneratedValue(strategy: 'UUID')]
//    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
//    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
//    private ?string $uuid = null;

    #[ORM\Column(length: 80)]
    #[Assert\Length(
        min: 10,
        max: 80,
        minMessage: 'Post title must be at least {{ limit }} characters long.',
        maxMessage: 'Post title cannot be longer than {{ limit }} characters',
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 20,
        minMessage: 'Post content must be at least {{ limit }} characters long.'
    )]
    private ?string $content = null;

    #[ORM\Column]
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "image_id", referencedColumnName: "id")]
    private ?string $image = null;

//    public function __construct()
//    {
//        $this->uuid = Uuid::v4();
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getUuid(): ?Uuid
//    {
//        return $this->uuid;
//    }

//    public function setUuid(Uuid $uuid = null): static
//    {
//        $this->uuid = null === $uuid ? Uuid::v4() : $uuid;
//
//        return $this;
//    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
