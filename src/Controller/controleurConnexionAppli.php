<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;
use JsonException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class controleurConnexionAppli extends AbstractController
{

	/**
	 * @Route("/session")
	 * @param ManagerRegistry $doctrine
	 * @param Request $request
	 * @return JsonResponse
	 * @throws JsonException
	 */
	public function index(ManagerRegistry $doctrine, Request $request): JsonResponse
	{

		$rep = new JsonResponse();
		$rep->headers->set('Content-Type', 'application/json');
		$rep->headers->set('Access-Control-Allow-Origin', '*');
		$rep->headers->set( "Access-Control-Allow-Credentials", true);
		$rep->headers->set("Access-Control-Allow-Headers", "Origin,Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token,locale");
		$rep->headers->set("Access-Control-Allow-Methods", "POST, OPTIONS");

		if ($content = $request->getContent())
		{
			$donnees = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
			if (isset($donnees["email"]) && !empty($donnees["email"]) && is_string($donnees["email"]))
			{
				if (isset($donnees["password"]) && !empty($donnees["password"]) && is_string($donnees["password"]))
				{
					$entite = $doctrine->getManager();
					$utilisateur = $entite->find(Utilisateur::class, $donnees["email"]);
					if ($utilisateur && $utilisateur->getPassword() === $donnees["password"])
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