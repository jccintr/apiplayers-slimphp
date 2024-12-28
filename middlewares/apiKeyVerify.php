<?php
//use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Psr7\Response as Response;

$apiKeyVerify = function(Request $request, RequestHandler $handler) {

   // $UserName = $request->getHeaderLine('X-API-User');
    $ApiKey = $request->getHeaderLine('X-API-Key');

    if(!$ApiKey) {
        return sendErrorResponse(['msg' => 'Chave de Api não informada']);
    }
   
    if($ApiKey != 'cacildabiscate'){
        return sendErrorResponse([
            'msg' => 'Chave de Api Inválida',
        ]);
    }


 

    $response = $handler->handle($request);
    return $response;
};

function sendErrorResponse($error) {
    $response = new Response();
    $response->getBody()->write(json_encode($error));
    $newResponse = $response->withStatus(401);
    return $newResponse;
}