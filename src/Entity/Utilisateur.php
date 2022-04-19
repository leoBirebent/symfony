<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=50)
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $passwd;


	public function __construct($id="", $passwd="")
	{
		$this->id = $id;
		$this->passwd = $passwd;
	}


	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}


	public function getRoles(): array
	{
		// TODO: Implement getRoles() method.
		return array();
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	public function getUserIdentifier(): string
	{
		// TODO: Implement getUserIdentifier() method.
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->passwd;
	}
}