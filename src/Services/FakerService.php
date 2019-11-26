<?php
namespace Author\Services;

use Faker\Factory;

/**
 * Class FakerService
 *
 * @category Faker
 * @package Author\Services
 */
class FakerService
{
    /**
     * Payload to parse
     *
     * @var String $payload
     */
    protected $payload;

    /**
     * Faker library
     *
     * @var \Faker\Generator $faker
     */
    protected $faker;

    /**
     * FakerService constructor.
     *
     * @param String $payload - Payload to parse
     *
     * @return void
     */
    public function __construct(String $payload)
    {
        $this->payload = $payload;
        $this->faker = Factory::create('en_GB');
    }

    /**
     * Parse all of the faker data
     *
     * @return string
     */
    public function parseAll(): string
    {
        $this->parseNames();
        $this->parseNumbers();
        $this->parseAddresses();

        return $this->payload;
    }

    /**
     * Parse all the types of faker names
     *
     * @return void
     */
    public function parseNames()
    {
        $this->payload = str_replace('!!NAME!!', $this->faker->name, $this->payload);
        $this->payload = str_replace('!!FIRST_NAME!!', $this->faker->firstName, $this->payload);
        $this->payload = str_replace('!!LAST_NAME!!', $this->faker->lastName, $this->payload);
        $this->payload = str_replace('!!EMAIL!!', $this->faker->email, $this->payload);
    }

    /**
     * Parse all the types of faker numbers
     *
     * @return void
     */
    public function parseNumbers()
    {
        $this->payload = str_replace('!!NUMBER!!', $this->faker->randomDigitNotNull, $this->payload);
    }

    /**
     * Parse all the types of faker addresses
     *
     * @return void
     */
    public function parseAddresses()
    {
        $this->payload = str_replace('!!STREET!!', $this->faker->streetName, $this->payload);
        $this->payload = str_replace('!!POSTCODE!!', $this->faker->postcode, $this->payload);
        $this->payload = str_replace('!!CITY!!',$this->faker->city,$this->payload);
    }

}