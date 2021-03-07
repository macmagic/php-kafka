<?php

declare(strict_types=1);

namespace App\Music\Ui\Action;

use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;
use App\Music\Application\Message\UploadMusicMessage;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class UploadMusicAction extends AbstractActionController
{
    private const ALLOWED_EXTENSIONS = ['mp3', 'ogg', 'wma', 'wav', 'zip'];

    private const REQUEST_FILE_KEY = 'file';

    private ParameterBagInterface $parametersBag;

    private array $allowedExtensions;

    private string $uploadDir;

    public function __construct(
        CloudBusInterface $cloudBus,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        ParameterBagInterface $parameterBag
    ) {
        parent::__construct($cloudBus, $commandBus, $queryBus);
        $this->parametersBag = $parameterBag;
        $this->allowedExtensions = $this->parametersBag->get('allowed_extensions');
        $this->uploadDir = $this->parametersBag->get('upload_dir');
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

            if (!\in_array($extension, $this->allowedExtensions, true)) {
                throw new UnsupportedMediaTypeHttpException(sprintf('The upload file is not valid, only files with %s extension are allowed', implode(',', self::ALLOWED_EXTENSIONS)));
            }

            try {
                $file->move($this->uploadDir, $filename);
            } catch (FileException $exception) {
                throw new BadRequestHttpException(sprintf('Something went wrong moving the file to the new directory: %s', $exception->getMessage()));
            }

            $message = new UploadMusicMessage($importId->toString(), $filename, $file->getClientOriginalName());
            $this->send($message);
        }

        return new Response('', Response::HTTP_CREATED);
    }
}
