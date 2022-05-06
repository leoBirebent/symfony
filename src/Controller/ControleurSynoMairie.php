<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ControleurSynoMairie
{
	/**
	 * @Route("/test2")
	 * @param ManagerRegistry $doctrine
	 * @param Request $request
	 * @return JsonResponse
	 * @throws JsonException
	 * @throws \JsonException
	 */
	public function test(): JsonResponse
	{
		$rep = new JsonResponse();

		$rep->headers->set('Content-Type', 'application/json');
		$rep->headers->set('Access-Control-Allow-Origin', '*');
		$rep->headers->set( "Access-Control-Allow-Credentials", true);
		$rep->headers->set("Access-Control-Allow-Headers", "Origin,Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token,locale");
		$rep->headers->set("Access-Control-Allow-Methods", "POST, OPTIONS");

		$server = "https://new-r-organisation.fr4.quickconnect.to";

		$requete = curl_init();

		// Return Page contents.


		$url = $server . '/webapi/query.cgi?api=SYNO.API.Info&method=Query&version=1&query=SYNO..';

		$defaults = array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => array( 'Content-Type: application/json'),
			CURLOPT_RETURNTRANSFER => TRUE,
		);

		curl_setopt_array($requete, $defaults);


		$json = curl_exec($requete);


		//$json = file_get_contents($server.'/webapi/query.cgi?api=SYNO.API.Info&method=Query&version=1&query=SYNO.',false, stream_context_create($arrContextOptions));
		/*
		$obj = json_decode($jsonApi, true, 512, JSON_THROW_ON_ERROR);

		$path = $obj->data->{'SYNO.API.Auth'}->path;


		header('Content-Type: application/json');

		$login = "administrateur";
		//$pass = "MAnaG3r16+";
		$pass = "B8KF2Gpw3nm93";
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
			$repRequete = "TROUVE";


			//$nomApi = "SYNO.SDS.Backup.Client.Common.Log";
			$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&offset=0&limit=0&_sid='.$sid, false, stream_context_create($arrContextOptions));

			//$nomApi = "SYNO.Backup.App2.Backup";
			//$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&_sid='.$sid, false, stream_context_create($arrContextOptions));

			//$nomApi = "SYNO.FileStation.BackgroundTask";
			//$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&_sid='.$sid, false, stream_context_create($arrContextOptions));

			$obj = json_decode($json);

			foreach($obj->data->log_list as $log)
			{

				$id_cam = $log->event;
				$repRequete .= "\nCam :" . $id_cam . "detected";
				//check if cam is connected

			}
			//$rep->setContent($json);
			$rep->setContent(json_encode($repRequete));
			$json = file_get_contents($server.'/webapi/'.$path.'?api=SYNO.API.Auth&method=Logout&version='.$vAuth.'&session=SurveillanceStation&_sid='.$sid, false, stream_context_create($arrContextOptions));
		}
		else
		{
			$rep->setContent($jsonLog);
		}
		*/

		if (!$json)
		{
			$er [0]= "Curl error: " . curl_error($requete) . "//";
			$er [1] = curl_getinfo($requete);
			$rep->setContent(json_encode($er));
		}
		else
		{
			$rep->setContent(json_encode($json));
		}

		curl_close($requete);

		return $rep;
	}
}