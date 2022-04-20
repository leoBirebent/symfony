<?php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class controleurConnexionAppli extends AbstractController
{

	/**
	 * @Route("/connAppli")
	 */
	public function index(ManagerRegistry $doctrine): string
	{
		$t = "fezfefzef";
		return json_encode($t);
	}
}
?>