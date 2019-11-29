<?php

namespace Author\Services;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

/**
 * Class KafkaService
 *
 * @package Author\Services
 */
class KafkaService
{
    /**
     * @var $broker
     */
    protected $broker;

    /**
     * @var $topic
     */
    protected $topic;

    /**
     * @var $payload
     */
    protected $payload;

    /**
     * @param $broker
     * @return $this
     * @throws \Exception
     */

    public function __construct()
    {
        $this->logger = new Logger('app-log');
        $this->logger->pushHandler(new StreamHandler( '/var/www/logs/app.log', Logger::DEBUG));
    }


    public function broker($broker)
    {
        $this->broker = $broker;
        return $this;
    }

    /**
     * @param $topic
     * @return $this
     */
    public function topic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @param $payload
     * @return $this
     */
    public function payload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param $amount
     *
     * @return array
     */
    public function produce($amount)
    {
        $conf = new \RdKafka\Conf();

        $conf->setErrorCb(function ($kafka, $err, $reason) {
            throw new \Exception(rd_kafka_err2str($err) . ": " . $reason);
        });

        $rk = new \RdKafka\Producer($conf);
        $rk->addBrokers($this->broker);

        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set("message.timeout.ms", "500");

        $topic = $rk->newTopic($this->topic, $topicConf);

        $payloads = [];

        for ($x = 1; $x <= $amount; $x++) {

            $payload = $this->payload;

            $fakerService = new FakerService($payload);

            $payload = $fakerService->parseAll();

            $payloads[] = $payload;

            try{
                $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload);
                $rk->poll(20);
            }catch(\Exception $e){
                $this->logger->log('error' , $e->getMessage());
                $errors[] = '{"error" : "'. $e->getMessage() . '"}';
                return $errors;
            }

        }

        return $payloads;
    }

    /**
     * @return mixed
     */
    public function consume()
    {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'kafka-author');
        $rk = new \RdKafka\Consumer($conf);
        $rk->addBrokers($this->broker);
        $topic = $rk->newTopic($this->topic);
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        return $topic->consume(0, 1000);
    }

}