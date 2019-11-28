<?php
namespace Author\Services;

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
     */
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
        $rk = new \RdKafka\Producer();

        $rk->addBrokers($this->broker);

        $topic = $rk->newTopic($this->topic);

        $payloads = [];

        for ($x = 1; $x <= $amount; $x++) {

            $payload = $this->payload;

            $fakerService = new FakerService($payload);

            $payload = $fakerService->parseAll();

            $payloads[] = $payload;

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload);
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