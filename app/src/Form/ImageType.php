<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends FileType
{
    public function __construct(readonly private string $imagePath)
    {
        parent::__construct();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder->addModelTransformer(new CallbackTransformer(
            function (Image $image = null) {
                if ($image instanceof Image) {
                    return new File($this->imagePath . $image->getFile());
                }
            },
            function (UploadedFile $uploadedFile = null) {
                if ($uploadedFile instanceof UploadedFile) {
                    $image = new Image();
                    $image->setFile($uploadedFile);

                    return $image;
                }
            }
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'image';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'required' => true
        ]);
    }
}
