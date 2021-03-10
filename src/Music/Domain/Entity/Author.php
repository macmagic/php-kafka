<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Music\Domain\Repository\AuthorRepositoryInterface")
 * @ORM\Table
 */
class Author
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
     * @ORM\Column(name="created_at", type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Album", mappedBy="author")
     */
    private PersistentCollection $albums;

    public function __construct(Uuid $id, string $name, DateTime $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getAlbums(): PersistentCollection
    {
        return $this->albums;
    }
}
