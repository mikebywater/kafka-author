<?php

namespace Author\Services;


class KafkaService
{
    protected $broker;
    protected $topic;
    protected $payload;



    public function broker($broker)
    {
        $this->broker = $broker;
        return $this;
    }

    public function topic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    public function payload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public function produce()
    {
        $rk = new \RdKafka\Producer();
        $rk->addBrokers($this->broker);
        $topic = $rk->newTopic($this->topic);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $this->payload);
    }


}