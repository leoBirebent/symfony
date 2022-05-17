<?php
namespace App\Controller;


use App\Entity\Information;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class controleurSyno extends AbstractController
{

	/**
	 * @Route("/test", name="test")
	 * @param ManagerRegistry $doctrine
	 * @param Request $request
	 * @return JsonResponse
	 * @throws JsonException
	 * @throws \JsonException
	 */
	public function test(): JsonResponse
	{
		$rep = new JsonResponse();
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);
		$rep->headers->set('Content-Type', 'application/json');
		$rep->headers->set('Access-Control-Allow-Origin', '*');
		$rep->headers->set( "Access-Control-Allow-Credentials", true);
		$rep->headers->set("Access-Control-Allow-Headers", "Origin,Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token,locale");
		$rep->headers->set("Access-Control-Allow-Methods", "POST, OPTIONS");


		$server = "https://10.150.5.1:59201";

		//$json = file_get_contents($server.'/webapi/query.cgi?api=SYNO.API.Info&method=Query&version=1&query=SYNO.',false, stream_context_create($arrContextOptions));
		$jsonApi = file_get_contents($server.'/webapi/query.cgi?api=SYNO.API.Info&method=Query&version=1&query=SYNO.',false, stream_context_create($arrContextOptions));
		$obj = json_decode($jsonApi, false, 512, JSON_THROW_ON_ERROR);


		$path = $obj->data->{'SYNO.API.Auth'}->path;


		header('Content-Type: application/json');

		//$login = "administrateur";
		$login = "cyril";
		// MAnaG3r16+
		$pass = "MAnaG3r16%2B";
		//$pass = "B8KF2Gpw3nm93";
		$vAuth = 6;
		$vApi = 1;

		//$nomApi = "SYNO.FolderSharing.List";
		//$nomApi = "SYNO.Backup.App2.Backup";
		$nomApi = "SYNO.SDS.Backup.Client.Common.Log";

		//$rep->setContent(json_encode($path));
		//$rep->setContent($json);

		$jsonLog = file_get_contents($server.'/webapi/'.$path.'?api=SYNO.API.Auth&method=Login&version='.$vAuth.'&account='.$login.'&passwd='.$pass.'&session=SurveillanceStation&format=sid',false, stream_context_create($arrContextOptions));
		$obj = json_decode($jsonLog);

		if($obj->success == "true")
		{

			//authentification successful
			$sid = $obj->data->sid;


			//Get SYNO.SurveillanceStation.Camera (recommended by Synology for further update)
			$json = file_get_contents($server.'/webapi/query.cgi?api=SYNO.API.Info&method=Query&version=1&query='.$nomApi, false, stream_context_create($arrContextOptions));
			$obj = json_decode($json);


			$path = $obj->data->{$nomApi}->path;


			//$nomApi = "SYNO.SDS.Backup.Client.Common.Log";
			$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&offset=0&limit=0&_sid='.$sid, false, stream_context_create($arrContextOptions));

			//$nomApi = "SYNO.Backup.App2.Backup";
			//$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&_sid='.$sid, false, stream_context_create($arrContextOptions));

			//$nomApi = "SYNO.FileStation.BackgroundTask";
			//$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&_sid='.$sid, false, stream_context_create($arrContextOptions));

			$obj = json_decode($json);
			$repRequete = ["Informations" => []];

			foreach($obj->data->log_list as $log)
			{
				$info = $log->level;
				$date = $log->time;
				$nomInfo = $log->event;
				if (str_starts_with($nomInfo, "[Network][Sauvegarde Cloud]") || true)
				{
					switch ($info)
					{
						case "info" :
							//$repRequete .= "\nInfo :" . $info . "detected";
							$classInfo = new Information("Succès", $date);
							break;
						case "err":
							//$repRequete .= "\nErreur :" . $info . "detected";
							$classInfo = new Information("Erreur", $date);
							break;
						default:
							//$repRequete .= "\nAvertissement :" . $info . "detected";
							$classInfo = new Information("Attention", $date);
					}
					$repRequete["Informations"][] = $classInfo;
				}

			}
			//$rep->setContent($json);
			$rep->setContent(json_encode($repRequete));
			$json = file_get_contents($server.'/webapi/'.$path.'?api=SYNO.API.Auth&method=Logout&version='.$vAuth.'&session=SurveillanceStation&_sid='.$sid, false, stream_context_create($arrContextOptions));
		}
		else
		{
			$rep->setContent(json_encode($server.'/webapi/'.$path.'?api=SYNO.API.Auth&method=Login&version='.$vAuth.'&account='.$login.'&passwd='.$pass.'&session=SurveillanceStation&format=sid'));
		}
		//$rep->setContent(json_encode($obj->data));
		return $rep;
	}
}
?>
