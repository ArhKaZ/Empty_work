<?php

namespace App\Service;

use Ferrandini\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHealper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadMotifCollection(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath . '/collection_motif';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }
}
