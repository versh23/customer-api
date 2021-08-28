<?php

declare(strict_types=1);

namespace App\Tests\Importer;

use App\Importer\CustomerImporter;
use App\Importer\DataProvider\CustomerProviderInterface;
use App\Repository\CustomerRepository;
use App\Tests\Factory\CustomerFactory;
use App\Tests\Factory\CustomerModelFactory;
use App\Tests\WebTestCase;

/**
 *  we can use TestCase class here.
 */
class CustomerImporterTest extends WebTestCase
{
    private CustomerImporter $importer;
    private CustomerProviderInterface $provider;

    protected function setUp(): void
    {
        $this->provider = $this->createMock(CustomerProviderInterface::class);
        $repo = self::getContainer()->get(CustomerRepository::class);
        $em = self::getContainer()->get('doctrine.orm.entity_manager');
        $this->importer = new CustomerImporter($this->provider, $repo, $em);
        parent::setUp();
    }

    public function testImport()
    {
        $return = CustomerModelFactory::createMany(100);

        $this->provider
            ->expects($this->once())
            ->method('fetch')
            ->with(100, 'AU')
            ->willReturn($return)
        ;

        $this->importer->import();

        $this->assertEquals(100, CustomerFactory::repository()->count());
    }

    public function testImportWithUpdate()
    {
        $first = CustomerModelFactory::createMany(1, [
            'email' => 'test@gmail.com',
        ]);

        $second = CustomerModelFactory::createMany(1, [
            'email' => 'test@gmail.com',
        ]);

        $this->provider
            ->method('fetch')
            ->willReturnOnConsecutiveCalls($first, $second)
        ;

        $this->importer->import();
        $this->assertEquals(1, CustomerFactory::repository()->count());

        $this->importer->import();
        $this->assertEquals(1, CustomerFactory::repository()->count());
    }
}
