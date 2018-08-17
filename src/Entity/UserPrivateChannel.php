<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPrivateChannel
 *
 * @ORM\Table(name="user_private_channel", uniqueConstraints={@ORM\UniqueConstraint(name="use_external", columns={"user_external_id"})})
 * @ORM\Entity
 */
class UserPrivateChannel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_external_id", type="string", length=20, nullable=false)
     */
    private $userExternalId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_private_bot_channel_id", type="string", length=20, nullable=false)
     */
    private $userPrivateBotChannelId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserExternalId(): ?string
    {
        return $this->userExternalId;
    }

    public function setUserExternalId(string $userExternalId): self
    {
        $this->userExternalId = $userExternalId;

        return $this;
    }

    public function getUserPrivateBotChannelId(): ?string
    {
        return $this->userPrivateBotChannelId;
    }

    public function setUserPrivateBotChannelId(string $userPrivateBotChannelId): self
    {
        $this->userPrivateBotChannelId = $userPrivateBotChannelId;

        return $this;
    }


}
