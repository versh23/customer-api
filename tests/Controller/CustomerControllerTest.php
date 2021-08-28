<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Factory\CustomerFactory;
use App\Tests\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class CustomerControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        parent::setUp();
    }

    public function testList(): void
    {
        $this->client->request('GET', '/customers');
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertCount(0, $content);

        CustomerFactory::createMany(10);

        $this->client->request('GET', '/customers');
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertCount(10, $content);
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('email', $content[0]);
        $this->assertArrayHasKey('country', $content[0]);
        $this->assertArrayHasKey('fullName', $content[0]);
    }

    public function testShow(): void
    {
        $this->client->request('GET', '/customers/1');
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(404);

        CustomerFactory::createMany(10);
        $last = CustomerFactory::last();

        $this->client->request('GET', '/customers/'.$last->id);
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('email', $content);
        $this->assertArrayHasKey('username', $content);
        $this->assertArrayHasKey('gender', $content);
        $this->assertArrayHasKey('city', $content);
        $this->assertArrayHasKey('phone', $content);
        $this->assertArrayHasKey('country', $content);
        $this->assertArrayHasKey('fullName', $content);
    }
}
