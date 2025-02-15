<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Cloud\CloudHandlerInterface;
use App\Music\Application\Message\UploadMusicMessage;
use App\Music\Domain\Service\UploadMusicService;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class UploadMusicMessageHandler implements CloudHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private UploadMusicService $uploadMusicService;

    public function __construct(UploadMusicService $uploadMusicService)
    {
        $this->uploadMusicService = $uploadMusicService;
    }

    public function __invoke(UploadMusicMessage $message): void
    {
        $this->logger->info('Get message from topic');
        try {
            $this->uploadMusicService->uploadMusic(
                $message->getFilename(),
                $message->getOriginalFilename()
            );
        } catch (Exception $exception) {
            $this->logger->error(sprintf('Cannot process the message: %s', $exception->getMessage()));
        }
        $this->logger->info('Process OK');
    }
}
