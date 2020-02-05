<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FiguresRepository")
 * @UniqueEntity("name")
 * @Vich\Uploadable()
 */
class Figures
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
	private $name;

	/**
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $filename;

	/**
	 * @var File|null
	 * @Assert\Image(
	 *     mimeTypes="image/jpeg"
	 * )
	 * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updated_at;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="figure")
	 */
	private $comments;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="figures")
	 */
	private $categories;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
		$this->categories = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->name;
	}

	public function getId(): ?int
	{
		return $this->id;
	}


	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getSlug(): string
	{
		return (new Slugify())->slugify($this->name);
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->created_at;
	}

	public function setCreatedAt(\DateTimeInterface $created_at): self
	{
		$this->created_at = $created_at;

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

	public function dateIsSame()
	{
		return $this->created_at == $this->updated_at;
	}

	/**
	 * @return Collection|Comment[]
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function addComment(Comment $comment): self
	{
		if (!$this->comments->contains($comment)) {
			$this->comments[] = $comment;
			$comment->setFigure($this);
		}

		return $this;
	}

	public function removeComment(Comment $comment): self
	{
		if ($this->comments->contains($comment)) {
			$this->comments->removeElement($comment);
			// set the owning side to null (unless already changed)
			if ($comment->getFigure() === $this) {
				$comment->setFigure(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Category[]
	 */
	public function getCategories(): Collection
	{
		return $this->categories;
	}

	public function addCategory(Category $category): self
	{
		if (!$this->categories->contains($category)) {
			$this->categories[] = $category;
			$category->addFigure($this);
		}

		return $this;
	}

	public function removeCategory(Category $category): self
	{
		if ($this->categories->contains($category)) {
			$this->categories->removeElement($category);
			$category->removeFigure($this);
		}

		return $this;
	}

	/**
	 * Get mimeTypes="image/jpeg"
	 *
	 * @return  File|null
	 */
	public function getImageFile()
	{
		return $this->imageFile;
	}

	/**
	 * Set mimeTypes="image/jpeg"
	 *
	 * @param  File|null  $imageFile  mimeTypes="image/jpeg"
	 *
	 * @return  self
	 */
	public function setImageFile($imageFile)
	{
		$this->imageFile = $imageFile;

		return $this;
	}

	/**
	 * Get the value of filename
	 *
	 * @return  string|null
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * Set the value of filename
	 *
	 * @param  string|null  $filename
	 *
	 * @return  self
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;

		return $this;
	}
}
