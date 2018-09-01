<?php

namespace Author\Controllers;

use Author\Services\KafkaService;
use Slim\Http\Request;
use Slim\Http\Response;

class KafkaConsumerController extends BaseController
{

    public function __invoke(Request $request, Response $response, $args) {
        // your code
        // to access items in the container... $this->container->get('');
        $data = $request->getParsedBody();

        $service = new KafkaService();
        $msg = $service->broker($data['broker'])
            ->topic($data['topic'])
            ->consume();


        return $response->write($msg->payload);
    }
}