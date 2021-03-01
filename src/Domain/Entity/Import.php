<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\ImportRepository")
 * @ORM\Table
 */
class Import
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="id", type="uuid")
     */
    private Uuid $id;

    /**
     * @ORM\Column(name="status", type="integer")
     */
    private int $status;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private DateTime $createdAt;
}
