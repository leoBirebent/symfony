<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
	/**
	 * @var string
	 *
	 * @ORM\Id
	 * @ORM\Column(type="string", length=50)
	 */
	private string $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="passwd", type="string", length=255, nullable=false)
	 */
	private string $passwd;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="permissions", type="string", length=255, nullable=false, options={"default"="UTILISATEUR", "string"="ADMIN", "string"="UTILISATEUR_ADMIN"}, )
	 */
	private string $permissions;


	public function __construct($id="", $passwd="", $permissions="UTILISATEUR")
	{
		$this->id = $id;
		$this->passwd = $passwd;
		if ($permissions !== "ADMIN" && $permissions !== "UTILISATEUR_ADMIN")
		{
			$this->permissions = "UTILISATEUR";
		}
		else
		{
			$this->permissions = $permissions;
		}

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

	/**
	 * @return string
	 */
	public function getPermissions(): string
	{
		return $this->permissions;
	}
}