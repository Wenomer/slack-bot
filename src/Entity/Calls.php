<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallRepository")
 */
class Calls
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $clicks_1;

    /**
     * @ORM\Column(type="integer")
     */
    private $clicks_2;

    /**
     * @ORM\Column(type="string")
     */
    private $user_1;

    /**
     * @ORM\Column(type="string")
     */
    private $user_2;

    public function getId()
    {
        return $this->id;
    }

    public function getUser1(): ?string
    {
        return $this->user_1;
    }

    public function getUser2(): ?string
    {
        return $this->user_2;
    }

    public function setUser1(string $user): self
    {
        $this->user_1 = $user;

        return $this;
    }

    public function setUser2(string $user): self
    {
        $this->user_2 = $user;

        return $this;
    }

    public function getClicks1(): ?int
    {
        return $this->clicks_1;
    }
    public function getClicks2(): ?int
    {
        return $this->clicks_2;
    }

    public function setClicks1(int $clicks): self
    {
        $this->clicks_1 = $clicks;

        return $this;
    }

    public function setClicks2(int $clicks): self
    {
        $this->clicks_2 = $clicks;

        return $this;
    }
}
