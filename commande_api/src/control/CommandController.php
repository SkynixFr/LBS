<?php

namespace lbs\command\control;
use lbs\command\model\Command;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class CommandController{
    public function getCommands(Request $req, Response $resp, array $args){
        $commandes = Command::select()->get();
        $resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json;charset=utf-8');
        $resp->getBody()->write(json_encode([
			'type' => 'collection',
			'count' => count($commandes),
			'commandes' => $commandes
		]));
    	return $resp;
    }
    public function getCommand(Request $req, Response $resp, array $args){
        $id = $args['id'];
        try{ 
            $commande = Command::select()->where('id','=', $id)->firstOrFail();
            $resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json;charset=utf-8');
            $resp->getBody()->write(json_encode([
            'type' => 'collection',
            'count' => 1,
            'commande' => $commande
            ]));    
        }catch(ModelNotFoundException $e){
            $resp = $resp->withStatus(500)->withHeader('Content-Type', 'application/json;charset=utf-8');
            $resp->getBody()->write(json_encode([
                'type' => 'error',
                'error' => 500,
                'message' => $e->getMessage()
            ]));
        } 
        return $resp;
    }
    public function createCommand(Request $req, Response $resp, $args){
        
        $input = $req->getParsedBody();

        if(isset($input->nom) && isset($input->mail) && isset($input->livraison)){
            try{
                $commande = new Command();
                $commande->nom = filter_var($input->nom, FILTER_SANITIZE_STRING);
                $commande->mail = filter_var($input->mail, FILTER_SANITIZE_EMAIL);
                $commande->livraison = filter_var($input->livraison, FILTER_SANITIZE_STRING);
                $commande->id = Uuid::uuid4();
                $commande->saveOrFail();

                $resp = $resp->withStatus(201)->withHeader('Content-Type', 'application/json;charset=utf-8')->withHeader('Location', '/commandes/$commandes->id');
                $resp->getBody()->write(json_encode([
                    'type' => 'collection',
                    'count' => 1,
                    'commandes' => $commande
                ]));
            }catch(ModelNotFoundException $e){
                $resp = $resp->withStatus(500)->withHeader('Content-Type', 'application/json;charset=utf-8');
                $resp->getBody()->write(json_encode([
                    'type' => 'error',
                    'error' => 500,
                    'message' => $e->getMessage()
                ]));
            }
        }else{
            $resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json;charset=utf-8');
            $resp->getBody()->write(json_encode([
                'type' => 'error',
                'error' => 400,
                'message' => "Erreur de données transmises"
            ]));
        }
        return $resp;
    }
    public function updateCommand(Request $req, Response $resp, $args){
        $input = $req->getParsedBody();
        $id = $args['id'];
        if(isset($input->nom) && isset($input->mail) && isset($input->livraison)){
            try{
                $commande = Command::select()->where('id','=', $id)->firstOrFail();
                $commande->nom = filter_var($input->nom, FILTER_SANITIZE_STRING);
                $commande->mail = filter_var($input->mail, FILTER_SANITIZE_EMAIL);
                $commande->livraison = filter_var($input->livraison, FILTER_SANITIZE_STRING);
                $commande->saveOrFail();

                $resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json;charset=utf-8');
                $resp->getBody()->write(json_encode([
                    'type' => 'collection',
                    'count' => 1,
                    'commande' => $commande
                ]));
            }catch(ModelNotFoundException $e){
                $resp = $resp->withStatus(404)->withHeader('Content-Type', 'application/json;charset=utf-8');
                $resp->getBody()->write(json_encode([
                    'type' => 'error',
                    'error' => 404,
                    'message' => $e->getMessage()
                ]));
            }  
        }else{
            $resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json;charset=utf-8');
            $resp->getBody()->write(json_encode([
                'type' => 'error',
                'error' => 500,
                'message' => "Erreur de données transmise"
            ]));
        }
        return $resp;
    }
}