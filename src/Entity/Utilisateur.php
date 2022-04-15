<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="testP2\YourBundle\Entity\")
 */
class Utilisateur
{
	#[ORM\Id]
	#[ORM\Column(type: 'string', length: 50)]
	private $id;

	#[ORM\Column(type: 'string', length: 255)]
	private $passwd;


	public function __construct($id="", $passwd="")
	{
		$this->id = $id;
		$this->passwd = $passwd;
	}


	/**
	 * @return string|null
	 */
	public function getId(): ?string
	{
		return $this->id;
	}

	/**
	 * @return string|null
	 */
	public function getPasswd(): ?string
	{
		return $this->passwd;
	}
}