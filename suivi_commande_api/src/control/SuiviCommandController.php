<?php

namespace lbs\command\control;
use lbs\command\model\Command;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class SuiviCommandController{
    public function getCommands(Request $req, Response $resp, array $args){
     /*   $params = $req->getQueryParams();
        $status = $params['s'];
        $page = $params['page'];
        $size = $params['size']; */

        $status = $req->getQueryParam['s'];
        
        // if(isset($params["status"])){
        //     $commandes = Command::select()->where("status", "=", $params['status'])->get();
        //     $resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json;charset=utf-8');
        //     $array_commandes = array();
        //     foreach($commandes as $commande){
        //         $links = "/commandes/" . $commande->id;
        //         array_push($array_commandes,
        //             array(
        //                     "command" => array(
        //                     "id" => $commande->id,
        //                     "nom" => $commande->nom, 
        //                     "created_at" => $commande->created_at, 
        //                     "livraison" => $commande->livraison, 
        //                     "status"=> $commande->status
        //                 ),
        //                 "links" => array(
        //                     "self" => array(
        //                         "href" => $links
        //                     )
        //                 )
        //             )
        //         );
        //     }
        //     $collection= array("type" => "collection", "count" => count($commandes), "commandes" => $array_commandes);
        //     $resp->getBody()->write(json_encode([
        //         $collection
        //     ]));
        // }if(isset($params["page"])){

        // }else{
        //     $commandes = Command::select()->get();
        //     $resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json;charset=utf-8');
        //     $array_commandes = array();
        //     foreach($commandes as $commande){
        //         $links = "/commandes/" . $commande->id;
        //         array_push($array_commandes,
        //             array(
        //                 "command" => array(
        //                     "id" => $commande->id,
        //                     "nom" => $commande->nom, 
        //                     "created_at" => $commande->created_at, 
        //                     "livraison" => $commande->livraison, 
        //                     "status"=> $commande->status
        //                 ),
        //                 "links" => array(
        //                     "self" => array(
        //                         "href" => $links
        //                     )
        //                 )
        //             )
        //         );
        //     }
        //     $collection= array("type" => "collection", "count" => count($commandes), "commandes" => $array_commandes);
        //     $resp->getBody()->write(json_encode([
        //         $collection
        //     ]));
        // }  
    	// return $resp;
    }
    public function queryBuilder($page, $status, $size){

        if($status !=null){
            $commandes = Command::select()->where("status", "=", $status)->get();
        }
        
    }
}