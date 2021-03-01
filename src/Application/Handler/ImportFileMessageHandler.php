<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Message\ImportFileMessage;
use App\Domain\Service\ImportMusicService;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportFileMessageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private ImportMusicService $importMusicService;

    public function __construct(ImportMusicService $importMusicService)
    {
        $this->importMusicService = $importMusicService;
    }

    public function __invoke(ImportFileMessage $message): void
    {
        $this->logger->info('Get message from topic');
        try {
            $this->importMusicService->importMusic(
                $message->getFilename(),
                $message->getUploadDir(),
                $message->getOriginalFilename()
            );
        } catch (Exception $exception) {
            $this->logger->error(sprintf('Cannot process the message: %s', $exception->getMessage()));
        }
        $this->logger->info('Process OK');
    }
}
