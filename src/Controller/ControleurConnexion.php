<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControleurConnexion extends AbstractController
{
	/**
	 * @Route("/connexion", name="connexion")
	 */
	public function verifConnexion(ManagerRegistry $doctrine): Response
	{
		$entityManager = $doctrine->getManager();


		$utilisateur = new Utilisateur("steasfaf", "gezfze", "ADMIN");

		// tell Doctrine you want to (eventually) save the Product (no queries yet)
		//$entityManager->persist($utilisateur);

		// actually executes the queries (i.e. the INSERT query)
		//$entityManager->flush();

		return new Response('Saved new product with id ');
	}
}
?>