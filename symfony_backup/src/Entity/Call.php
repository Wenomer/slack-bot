<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Call
 *
 * @ORM\Table(name="call")
 * @ORM\Entity
 */
class Call
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_1", type="string", length=255, nullable=true)
     */
    private $user1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="clicks_1", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $clicks1 = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_2", type="string", length=255, nullable=true)
     */
    private $user2;

    /**
     * @var int|null
     *
     * @ORM\Column(name="clicks_2", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $clicks2 = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): ?string
    {
        return $this->user1;
    }

    public function setUser1(?string $user1): self
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getClicks1(): ?int
    {
        return $this->clicks1;
    }

    public function setClicks1(?int $clicks1): self
    {
        $this->clicks1 = $clicks1;

        return $this;
    }

    public function getUser2(): ?string
    {
        return $this->user2;
    }

    public function setUser2(?string $user2): self
    {
        $this->user2 = $user2;

        return $this;
    }

    public function getClicks2(): ?int
    {
        return $this->clicks2;
    }

    public function setClicks2(?int $clicks2): self
    {
        $this->clicks2 = $clicks2;

        return $this;
    }


}
