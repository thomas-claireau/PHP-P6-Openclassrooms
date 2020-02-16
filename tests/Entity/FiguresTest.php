<?php

namespace App\Tests\Entity;

use App\Entity\Figures;
use PHPUnit\Framework\TestCase;


class ArticleTest extends TestCase
{
	public function testName()
	{
		$figure = new Figures();
		$name = "Test de nom de figure";

		$figure->setName($name);
		$this->assertEquals("Test de nom de figure", $figure->getName());
	}

	public function testDescription()
	{
		$figure = new Figures();
		$description = "Test de description de figure";

		$figure->setDescription($description);
		$this->assertEquals("Test de description de figure", $figure->getDescription());
	}

	public function testCreatedAt()
	{
		$figure = new Figures();
		$date = new \DateTime();
		$createdAt = $date;

		$figure->setCreatedAt($createdAt);
		$this->assertEquals($date, $figure->getCreatedAt());
	}

	public function testUpdatedAt()
	{
		$figure = new Figures();
		$date = new \DateTime();
		$updatedAt = $date;

		$figure->setUpdatedAt($updatedAt);
		$this->assertEquals($date, $figure->getUpdatedAt());
	}
}
