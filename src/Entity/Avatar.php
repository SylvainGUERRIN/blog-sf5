<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvatarRepository")
 */
class Avatar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_avatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlAvatar(): ?string
    {
        return $this->url_avatar;
    }

    public function setUrlAvatar(string $url_avatar): self
    {
        $this->url_avatar = $url_avatar;

        return $this;
    }
}
