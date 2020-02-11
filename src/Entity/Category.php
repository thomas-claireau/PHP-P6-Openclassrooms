<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity("name")
 */
class Category
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
	 * @ORM\ManyToMany(targetEntity="App\Entity\Figures", mappedBy="categories")
	 */
	private $figures;

	public function __construct()
	{
		$this->figures = new ArrayCollection();
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

	/**
	 * @return Collection|Figures[]
	 */
	public function getFigures(): Collection
	{
		return $this->figures;
	}

	public function addFigure(Figures $figure): self
	{
		if (!$this->figures->contains($figure)) {
			$this->figures[] = $figure;
		}

		return $this;
	}

	public function removeFigure(Figures $figure): self
	{
		if ($this->figures->contains($figure)) {
			$this->figures->removeElement($figure);
		}

		return $this;
	}
}
