<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/consume', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'consume.phtml', $args);
});

$app->post('/', \Author\Controllers\KafkaProducerController::class);
