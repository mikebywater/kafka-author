<?php
namespace Author\Controllers;

use Author\Services\KafkaService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class KafkaConsumerController
 *
 * @category Consume
 * @package Author\Controllers
 */
class KafkaConsumerController extends BaseController
{
    /**
     * consume the specified Kafka event on given topic and payload.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response) {

        $data = $request->getParsedBody();

        $service = new KafkaService();

        $msg = $service->broker($data['broker'])
            ->topic($data['topic'])
            ->consume();

        return $response->write($msg->payload);
    }
}