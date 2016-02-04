<?php

/**
 * Clase de inicio del proyecto
 * Created by: braren
 * Date: 03/02/16
 * Time: 22:55
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/httpClient.class.php';

$appAPI = new \Slim\App;

$appAPI->get('/actor/{id_actor}', function (Request $request, Response $response) {
    $httpClient = new httpClient();

    $idActor = $request->getAttribute('id_actor');

    $response->getBody()->write($httpClient->getFullActorInfo($idActor));
    $response = $response->withHeader('Content-type', 'application/json');

    return $response;
});

$appAPI->get('/suggestion/{query}', function (Request $request, Response $response) {
    $httpClient = new httpClient();

    $query = $request->getAttribute('query');

    $response->getBody()->write($httpClient->getSuggestions($query));
    $response = $response->withHeader('Content-type', 'application/json');

    return $response;
});

$appAPI->run();
