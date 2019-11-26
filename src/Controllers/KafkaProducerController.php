<?php
namespace Author\Controllers;

use Author\Services\KafkaService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class KafkaProducerController
 *
 * @category Producer
 * @package Author\Controllers
 */
class KafkaProducerController extends BaseController
{
    /**
     * Produce the specified Kafka event on given topic and payload.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $service = new KafkaService();

        $result = $service->payload($data['payload'])
            ->broker($data['broker'])
            ->topic($data['topic'])
            ->produce($data['amount']);

        return $response->write(json_encode($result));
    }
}