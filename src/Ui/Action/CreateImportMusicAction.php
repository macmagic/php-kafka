<?php

declare(strict_types=1);

namespace App\Ui\Action;

use App\Application\Message\ImportFileMessage;
use App\Domain\Bus\Cloud\CloudBusInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class CreateImportMusicAction
{
    private const ALLOWED_EXTENSIONS = ['mp3', 'ogg', 'wma', 'wav', 'zip'];

    private const REQUEST_FILE_KEY = 'file';

    private CloudBusInterface $cloudBus;

    private string $uploadTmpDir;

    public function __construct(CloudBusInterface $cloudBus, string $uploadTmpDir)
    {
        $this->cloudBus = $cloudBus;
        $this->uploadTmpDir = $uploadTmpDir;
    }

    public function __invoke(Request $request): Response
    {
        $files = $request->files->get(self::REQUEST_FILE_KEY);

        if (0 === \count($files)) {
            throw new UnprocessableEntityHttpException('No file specified');
        }

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $importId = Uuid::uuid4();
            $extension = $file->getClientOriginalExtension();
            $filename = sprintf('%s.%s', $importId->toString(), $extension);

            if (!\in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
                throw new UnsupportedMediaTypeHttpException(sprintf('The upload file is not valid, only files with %s extension are allowed', implode(',', self::ALLOWED_EXTENSIONS)));
            }

            try {
                $file->move($this->uploadTmpDir, $filename);
            } catch (FileException $exception) {
                throw new BadRequestHttpException(sprintf('Something went wrong moving the file to the new directory: %s', $exception->getMessage()));
            }

            $message = new ImportFileMessage($importId->toString(), $this->uploadTmpDir, $filename, $file->getClientOriginalName());
            $this->cloudBus->send($message);
        }

        return new Response(null, Response::HTTP_CREATED);
    }
}
