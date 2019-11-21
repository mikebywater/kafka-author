<?php

namespace Author\Controllers;

use Author\Services\FakerService;
use Author\Services\KafkaService;
use Slim\Http\Request;
use Slim\Http\Response;

class KafkaProducerController extends BaseController
{

    public function __invoke(Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $fakerService = new FakerService($data['payload']);
        $data['payload'] = $fakerService->parseAll();
        $service = new KafkaService();
        $service->payload($data['payload'])
            ->broker($data['broker'])
            ->topic($data['topic'])
            ->produce();


        return $response->write($data['payload']);
    }
}