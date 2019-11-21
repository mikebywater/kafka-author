<?php


namespace Author\Services;

use Faker\Factory;

class FakerService
{
    public function __construct(String $payload)
    {
        $this->payload = $payload;
        $this->faker = Factory::create('en_GB');
    }

    public function parseAll()
    {
        $this->parseNames();
        $this->parseNumbers();
        $this->parseAddresses();
        return $this->payload;
    }

    public function parseNames()
    {

        $this->payload = str_replace('!!NAME!!', $this->faker->name(), $this->payload);
        $this->payload = str_replace('!!FIRST_NAME!!', $this->faker->firstName(), $this->payload);
        $this->payload = str_replace('!!LAST_NAME!!', $this->faker->lastName(), $this->payload);
        return $this->payload;
    }

    public function parseNumbers()
    {
        $this->payload = str_replace('!!NUMBER!!', $this->faker->randomDigitNotNull(), $this->payload);
        return $this->payload;
    }

    public function parseAddresses()
    {
        $this->payload = str_replace('!!STREET!!', $this->faker->streetName(), $this->payload);
        $this->payload = str_replace('!!POSTCODE!!', $this->faker->postcode(), $this->payload);
        return $this->payload;
    }

}