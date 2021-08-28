<?php

declare(strict_types=1);

namespace App\Tests;

use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class WebTestCase extends SymfonyWebTestCase
{
    use Factories;
    use ResetDatabase;

    protected function setUp(): void
    {
        self::bootKernel();

        parent::setUp();
    }

    protected static function commitAndDie()
    {
        StaticDriver::commit();
        exit;
    }
}
