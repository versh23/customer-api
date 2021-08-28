<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Customer;
use App\Importer\CustomerModel;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<CustomerModel>
 */
final class CustomerModelFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->firstName(),
            'email' => self::faker()->unique()->email(),
            'country' => self::faker()->country(),
            'username' => self::faker()->userName(),
            'gender' => self::faker()->randomElement(['male', 'female']),
            'city' => self::faker()->city(),
            'phone' => self::faker()->phoneNumber(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            ->withoutPersisting()
            // ->afterInstantiate(function(Customer $customer) {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerModel::class;
    }
}
