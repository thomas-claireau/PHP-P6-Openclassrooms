<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainPictureRepository")
 */
class MainPicture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Figures", mappedBy="mainPicture", cascade={"persist", "remove"})
     */
    private $figures;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFigures(): ?Figures
    {
        return $this->figures;
    }

    public function setFigures(?Figures $figures): self
    {
        $this->figures = $figures;

        // set (or unset) the owning side of the relation if necessary
        $newMainPicture = null === $figures ? null : $this;
        if ($figures->getMainPicture() !== $newMainPicture) {
            $figures->setMainPicture($newMainPicture);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
