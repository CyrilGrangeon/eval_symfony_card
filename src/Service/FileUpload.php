<?php
namespace App\Service;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class FileUpload
{
    private $targetDirectory;
    

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $originalFilename;
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function fileDelete(?string $image) : void
    {
        $fileSystem = new Filesystem();
        $fileExist = $fileSystem->exists($this->getTargetDirectory(). '/' . $image);

        if($image != null && $fileExist) {
                unlink($this->getTargetDirectory(). '/' . $image);
        }
    }
}