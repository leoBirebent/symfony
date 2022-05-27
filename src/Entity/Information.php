<?php

namespace App\Entity;

class Information
{
	/**
	 * @var string
	 */
	public string $nom;

	/**
	 * @var string
	 */
	public string $date;

	/**
	 * @var string
	 */
	public string $information;

	public function __construct($nom, $date, $information)
	{
		$this->nom = $nom;
		$this->date = $date;
		$this->information = $information;
	}
}