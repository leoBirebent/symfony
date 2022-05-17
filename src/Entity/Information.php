<?php

namespace App\Entity;

class Information
{
	/**
	 * @var string
	 */
	public string $information;

	/**
	 * @var string
	 */
	public string $date;

	public function __construct($information, $date)
	{
		$this->information = $information;
		$this->date = $date;
	}
}