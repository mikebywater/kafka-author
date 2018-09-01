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

    public function consume()
    {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'mike');
        $rk = new \RdKafka\Consumer($conf);
        $rk->addBrokers($this->broker);
        $topic = $rk->newTopic($this->topic);

// The first argument is the partition to consume from.
// The second argument is the offset at which to start consumption. Valid values
// are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        return $topic->consume(0, 1000);


    }


}