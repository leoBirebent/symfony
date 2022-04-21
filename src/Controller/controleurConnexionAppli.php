<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class controleurConnexionAppli extends AbstractController
{

	/**
	 * @Route("/connAppli")
	 * @throws \JsonException
	 */
	public function index(ManagerRegistry $doctrine, Request $request): Response
	{

		$donnees = [];
		$rep = new Response();
		$rep->headers->set('Content-Type', 'application/json');
		$rep->headers->set('Access-Control-Allow-Origin', '*');
		if ($content = $request->getContent())
		{
			$donnees = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
			if (isset($donnees["id"]) && !empty($donnees["id"]) && is_string($donnees["id"]))
			{
				if (isset($donnees["mdp"]) && !empty($donnees["mdp"]) && is_string($donnees["mdp"]))
				{
					$entite = $doctrine->getManager();
					$utilisateur = $entite->find(Utilisateur::class, $donnees["id"]);
					if ($utilisateur && $utilisateur->getPassword() === $donnees["mdp"])
					{
							$rep->setContent(
							json_encode("Succes", JSON_THROW_ON_ERROR)
						);
					}
					else
					{
						$rep->setContent(
							json_encode("Erreur: Identifiant ou Mot de passe incorrect!", JSON_THROW_ON_ERROR)
						);
					}
				}
				else
				{
					$rep->setContent(
						json_encode("Erreur: Mot de passe manquant!", JSON_THROW_ON_ERROR)
					);
				}
			}
			else
			{
				$rep->setContent(
					json_encode("Erreur: Identifiant manquant!", JSON_THROW_ON_ERROR)
				);
			}

		}
		else
		{
			$rep->setContent(
				json_encode("Erreur: informations manquantes!", JSON_THROW_ON_ERROR)
			);
		}

		return $rep;
	}
}
?>