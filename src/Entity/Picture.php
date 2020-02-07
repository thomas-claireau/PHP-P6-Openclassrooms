<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @Vich\Uploadable()
 */
class Picture
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var File|null
	 * @Assert\Image(
	 *     mimeTypes={"image/png", "image/jpeg"}
	 * )
	 * @Vich\UploadableField(mapping="figure_image", fileNameProperty="filename")
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $filename;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Figures", inversedBy="pictures")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $figures;

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

		return $this;
	}

	/**
	 * @return null|File
	 */
	public function getImageFile(): ?File
	{
		return $this->imageFile;
	}

	/**
	 * @param null|File $imageFile
	 * @return self
	 */
	public function setImageFile(?File $imageFile): self
	{
		$this->imageFile = $imageFile;
		return $this;
	}
}
