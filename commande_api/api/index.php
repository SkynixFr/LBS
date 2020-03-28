<?php  
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../src/vendor/autoload.php';
$conf = parse_ini_file("../src/conf/conf.ini");
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($conf);
$db->setAsGlobal();
$db->bootEloquent();

$configuration = ['settings' => ['displayErrorDetails' => true]];
$c = new \Slim\Container($configuration);
/*$c['notFoundHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response->withStatus(400)
            ->withHeader('Content-Type', 'text/html')
            ->write('400 Bad Request');
    };
};
$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('500 Internal Server Error');
    };
};
$c['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response->withStatus(405)
            ->withHeader('Content-Type', 'text/html')
            ->write('405 Method Not Allowed');
    };
};
*/
$app = new \Slim\App($c);

/*$app->get('/hello/{name}',
	function (Request $req, Response $resp, $args){
		$name = $args['name'];
		$resp->getBody()->write("Hello, $name");
		return $resp;
	}
);*/
$app->post('/commandes[/]', \lbs\command\control\CommandController::class . ':createCommand');
$app->get('/commandes[/]', \lbs\command\control\CommandController::class . ':getCommands');
$app->get('/commandes/{id}', \lbs\command\control\CommandController::class . ':getCommand');
$app->put('/commandes/{id}', \lbs\command\control\CommandController::class . ':updateCommand');

$app->run();
