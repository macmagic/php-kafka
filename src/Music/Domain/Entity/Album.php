<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Music\Domain\Repository\AlbumRepositoryInterface")
 * @ORM\Table
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @ORM\Column(name="id", type="uuid")
     */
    private Uuid $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @ORM\Column(name="year", type="integer")
     */
    private int $year;

    /**
     * @ORM\Column(name="cover_filename", type="string", nullable=true)
     */
    private string $coverFilename;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="albums")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private Author $author;

    /**
     * @ORM\OneToMany(targetEntity="Song", mappedBy="album")
     */
    private PersistentCollection $songs;

    public function __construct(Uuid $id, string $name, int $year, string $coverFilename, DateTime $createdAt, Author $author)
    {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->coverFilename = $coverFilename;
        $this->createdAt = $createdAt;
        $this->author = $author;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCoverFilename(): string
    {
        return $this->coverFilename;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getSongs(): PersistentCollection
    {
        return $this->songs;
    }
}
