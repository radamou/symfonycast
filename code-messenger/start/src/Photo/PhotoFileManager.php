<?php

namespace App\Photo;

use App\Entity\ImagePost;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoFileManager
{
    /** @var FilesystemInterface  */
    private $filesystem;
    /** @var string */
    private $publicAssetBaseUrl;

    public function __construct(FilesystemInterface $photoFilesystem, string $publicAssetBaseUrl)
    {
        $this->filesystem = $photoFilesystem;
        $this->publicAssetBaseUrl = $publicAssetBaseUrl;
    }

    public function uploadImage(File $file): string
    {
        $originalFilename = $file->getFilename();

        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        }

        $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME).'-'.uniqid().'.'.$file->guessExtension();
        $stream = fopen($file->getPathname(), 'r');

        try {
            $result = $this->filesystem->writeStream(
                $newFilename,
                $stream,
                [
                    'visibility' => AdapterInterface::VISIBILITY_PUBLIC
                ]
            );


            if ($result === false) {
                throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
            }

        }catch (FileExistsException $e) {
            throw new FileExistsException($e->getMessage());
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFilename;
    }

    public function deleteImage(string $filename): void
    {
        // make it a bit slow
        sleep(3);

        try {
            $this->filesystem->delete($filename);
        }catch (FileNotFoundException $e) {
            throw new FileNotFoundException($e->getMessage());
        }
    }

    public function getPublicPath(ImagePost $imagePost): string
    {
        return $this->publicAssetBaseUrl.'/'.$imagePost->getFilename();
    }

    public function read(string $filename): string
    {
        try {
            return $this->filesystem->read($filename);
        }catch (FileNotFoundException $e) {
            throw new FileNotFoundException($e->getMessage());
        }
    }

    public function update(string $filename, string $updatedContents): void
    {
        try {
            $this->filesystem->update($filename, $updatedContents);
        }catch (FileNotFoundException $e) {
            throw new FileNotFoundException($e->getMessage());
        }
    }
}
