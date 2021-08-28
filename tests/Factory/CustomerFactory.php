<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Customer;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Customer>
 */
final class CustomerFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            'firstname' => self::faker()->text(),
            'lastname' => self::faker()->text(),
            'email' => self::faker()->text(),
            'username' => self::faker()->text(),
            'gender' => self::faker()->text(),
            'city' => self::faker()->text(),
            'phone' => self::faker()->text(),
            'country' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Customer $customer) {})
        ;
    }

    protected static function getClass(): string
    {
        return Customer::class;
    }
}
