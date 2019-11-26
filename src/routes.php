<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {

    // Render index view
    $this->renderer->setLayout("layout.phtml");

    return $this->renderer->render($response, 'index.phtml', ['page' => 'produce']);
});

$app->get('/consume', function (Request $request, Response $response) {
    // Render consumer
    $this->renderer->setLayout("layout.phtml");
    return $this->renderer->render($response, 'consume.phtml', ['page' => 'consume']);
});

$app->post('/', \Author\Controllers\KafkaProducerController::class);

$app->post('/consume', \Author\Controllers\KafkaConsumerController::class);
