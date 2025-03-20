<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class EmployeeApiTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->truncateEmployeeTable();
        parent::tearDown();
    }

    private function truncateEmployeeTable(): void
    {
        $entityManager = static::getContainer()->get('doctrine')->getManager();
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement($platform->getTruncateTableSQL('employee', true));
    }

    public function testCreateEmployee(): void
    {
        $client = static::createClient(['reboot' => false]);
        $response = $client->request('POST', '/api/employees', [
            'json' => [
                'firstName' => 'John',
                'lastName'  => 'Doe',
                // Використовуємо постійний email, бо таблиця очищається після тесту
                'email'     => 'john.doe@example.com',
                'hiredAt'   => (new \DateTimeImmutable('tomorrow'))->format('Y-m-d\TH:i:sP'),
                'salary'    => 150,
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'firstName' => 'John',
            'lastName'  => 'Doe',
            'email'     => 'john.doe@example.com'
        ]);
    }

    public function testGetEmployeeCollection(): void
    {
        $client = static::createClient(['reboot' => false]);
        $client->request('GET', '/api/employees');
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateEmployee(): void
    {
        $client = static::createClient(['reboot' => false]);

        $response = $client->request('POST', '/api/employees', [
            'json' => [
                'firstName' => 'Jane',
                'lastName'  => 'Doe',
                'email'     => 'jane.doe@example.com',
                'hiredAt'   => (new \DateTimeImmutable('tomorrow'))->format('Y-m-d\TH:i:sP'),
                'salary'    => 200,
            ]
        ]);

        $data = $response->toArray();
        $employeeId = $data['id'];

        $client->request('PUT', "/api/employees/{$employeeId}", [
            'json' => [
                'firstName' => 'Jane Updated',
                'lastName'  => 'Doe',
                'email'     => 'jane.updated@example.com',
                'hiredAt'   => (new \DateTimeImmutable('tomorrow'))->format('Y-m-d\TH:i:sP'),
                'salary'    => 250,
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteEmployee(): void
    {
        $client = static::createClient(['reboot' => false]);

        $response = $client->request('POST', '/api/employees', [
            'json' => [
                'firstName' => 'Mark',
                'lastName'  => 'Smith',
                'email'     => 'mark.smith@example.com',
                'hiredAt'   => (new \DateTimeImmutable('tomorrow'))->format('Y-m-d\TH:i:sP'),
                'salary'    => 180,
            ]
        ]);

        $data = $response->toArray();
        $employeeId = $data['id'];

        $client->request('DELETE', "/api/employees/{$employeeId}");
        $this->assertResponseStatusCodeSame(204);
    }
}
