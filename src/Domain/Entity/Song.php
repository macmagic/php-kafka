<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\SongRepository")
 * @ORM\Table
 */
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @ORM\Column(name="id", type="uuid")
     */
    private Uuid $id;

    /**
     * @ORM\Column(name="filename",type="string")
     */
    private string $filename;

    /**
     * @ORM\Column(name="original_filename", type="string")
     */
    private string $originalFilename;

    /**
     * @ORM\Column(name="file_size", type="integer")
     */
    private int $fileSize;

    /**
     * @ORM\Column(name="title",type="string")
     */
    private string $title;

    /**
     * @ORM\Column(name="duration",type="string")
     */
    private string $duration;

    /**
     * @ORM\Column(name="track_number",type="integer")
     */
    private int $trackNumber;

    /**
     * @ORM\Column(name="quality",type="string")
     */
    private string $quality;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="songs")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private Album $album;

    public function __construct(
        Uuid $id,
        string $filename,
        string $originalFilename,
        int $fileSize,
        string $title,
        string $duration,
        int $trackNumber,
        string $quality,
        DateTime $createdAt,
        Album $album)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
        $this->fileSize = $fileSize;
        $this->title = $title;
        $this->duration = $duration;
        $this->trackNumber = $trackNumber;
        $this->quality = $quality;
        $this->createdAt = $createdAt;
        $this->album = $album;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }
}
