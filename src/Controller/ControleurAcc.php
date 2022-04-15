<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControleurAcc extends AbstractController
{

	#[Route('/', name: 'accueil')]
	public function index(Request $request): Response
	{
		/*return $this->render('conference/index.html.twig',
				['controller_name'=>'Controleur Accueil']);
		*/
		$greet = '';
		if ($name = $request->query->get('hello'))
		{
			$greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
		}
		dump($request);
		$l = $_SERVER["HTTP_USER_AGENT"];
		return new Response(<<<EOF
<html>
<head>
<title>Accueil</title>
</head>
<body>
$l
SALUT
$greet
<img src="/images/under-construction.gif" />
</body>
</html>
EOF
		);
	}
}
?>