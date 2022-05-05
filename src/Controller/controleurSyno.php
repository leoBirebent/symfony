<?php
namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class controleurSyno extends AbstractController
{

	/**
	 * @Route("/test", name="login")
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

		$login = "cyril";
		//$pass = "MAnaG3r16+";
		$pass = "MAnaG3r16%2B";
		$vAuth = 6;
		$vApi = 2;

		$nomApi = "SYNO.Backup.App2.Backup";
		//$nomApi = "SYNO.SDS.Backup.Client.Common.Log";

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
			//$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&offset=0&limit=0&_sid='.$sid, false, stream_context_create($arrContextOptions));

			//$nomApi = "SYNO.Backup.App2.Backup";
			$json = file_get_contents($server.'/webapi/'.$path.'?api='.$nomApi.'&version='.$vApi.'&method=list&_sid='.$sid, false, stream_context_create($arrContextOptions));
			$obj = json_decode($json);
			/*

			foreach($obj->data->cameras as $cam)
			{

				$id_cam = $cam->id;
				$repRequete .= "\nCam :" . $id_cam . "detected";
				//check if cam is connected
				if(!$cam->status)
				{
					//check if cam is activated and not recording
					if($cam->enabled && !$cam->recStatus)
					{
						//showing a snapshot of the camera
						//echo "<img src='".$server."/webapi/".$path."?api=SYNO.SurveillanceStation.Camera&version=1&method=GetSnapshot&preview=true&camStm=1&cameraId=".$id_cam."&_sid=".$sid."' alt='limage toto' width='320' height='240'>";
					}
					else
					{
						//echo "<p>Cam " . $id_cam . " skipped</p>";
						$repRequete .= "// skipped";
					}
				}
				else
				{
					$rep .= "// deconnected";
				}
			}*/
			//$rep->setContent(json_encode($server.'/webapi/'.$path.'?api=SYNO.SDS.Backup.Client.Common.Log&version='.$vCamera.'&method=List&_sid='.$sid));
			$rep->setContent($json);
			$json = file_get_contents($server.'/webapi/'.$path.'?api=SYNO.API.Auth&method=Logout&version='.$vAuth.'&session=SurveillanceStation&_sid='.$sid, false, stream_context_create($arrContextOptions));
		}
		else
		{
			$rep->setContent($jsonLog);
		}
		return $rep;
	}
}
?>
