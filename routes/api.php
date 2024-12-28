<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/db.php';
include __DIR__ . '/../middlewares/apiKeyVerify.php';

$app->get('/players', function (Request $request, Response $response, $args) {
    
    $queryBuilder = $this->get("DB")->getQueryBuilder();
    $queryBuilder->select('id','Name','Team','Category')->from('Players')->orderBy('name', 'ASC');
    $results = $queryBuilder->executeQuery()->fetchAllAssociative();
    $response->getBody()->write(json_encode($results));
   
    return $response->withHeader('Content-Type','Application/json')->withStatus(200);
    
});

$app->get('/players/{id}', function (Request $request, Response $response, $args) {
    
    $id = $args['id'];

    $queryBuilder = $this->get("DB")->getQueryBuilder();
    $queryBuilder->select('id','Name','Team','Category')->from('Players')->where('id = ?');
    $queryBuilder->setParameter(0, $id);
    $result = $queryBuilder->executeQuery()->fetchAssociative();
    $response->getBody()->write(json_encode($result));
   
    return $response->withHeader('Content-Type','Application/json')->withStatus(200);

});

$app->post('/players', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
   
    $queryBuilder = $this->get("DB")->getQueryBuilder();
    $queryBuilder
    ->insert('players')
    ->setValue('name', '?')
    ->setValue('team', '?')
    ->setValue('category', '?')
    ->setParameter(0, $body['name'])
    ->setParameter(1, $body['team'])
    ->setParameter(2, $body['category']);
    $result = $queryBuilder->executeStatement();
    $body = json_encode(['mensagem'=>'Incluido com sucesso']);
    $response->getBody()->write($body);
    return $response->withHeader('Content-Type','Application/json')->withStatus(201);
});

$app->delete('/players/{id}', function (Request $request, Response $response, $args) {
    
    $id = $args['id'];
    $queryBuilder = $this->get("DB")->getQueryBuilder();
    $queryBuilder->delete('players')->where('id = ?');
    $queryBuilder->setParameter(0, $id);
    $result = $queryBuilder->executeStatement();
    $body = json_encode(['mensagem'=>'Excluído com sucesso']);
    $response->getBody()->write($body);
    return $response->withHeader('Content-Type','Application/json')->withStatus(200);
});

$app->put('/players/{id}', function (Request $request, Response $response, $args) {

    $id = $args['id'];
    
    $body = $request->getParsedBody();
  
    $queryBuilder = $this->get("DB")->getQueryBuilder();
    $queryBuilder->update('players')
    ->set('name', '?')
    ->set('team', '?')
    ->set('category', '?')
    ->where('id = ?');
    $queryBuilder->setParameter(0, $body['name']);
    $queryBuilder->setParameter(1, $body['team']);
    $queryBuilder->setParameter(2, $body['category']);
    $queryBuilder->setParameter(3, $id);
    $result = $queryBuilder->executeStatement();
    $body = json_encode(['mensagem'=>'Alterado com sucesso']);
    $response->getBody()->write($body);
    return $response->withHeader('Content-Type','Application/json')->withStatus(200);

})->add($apiKeyVerify);;  