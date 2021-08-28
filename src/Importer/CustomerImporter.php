<?php

declare(strict_types=1);

namespace App\Importer;

use App\Entity\Customer;
use App\Importer\DataProvider\CustomerProviderInterface;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CustomerImporter
{
    private const BATCH_SIZE = 100;

    public function __construct(
        private CustomerProviderInterface $provider,
        private CustomerRepository $repository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function import(int $limit = 100, string $nationality = Nationality::AU): void
    {
        $counter = 0;

        foreach ($this->provider->fetch($limit, $nationality) as $customerModel) {
            ++$counter;

            $customer = $this->repository->findOneBy([
                'email' => $customerModel->email,
            ]);

            if (!$customer) {
                $customer = new Customer();
                $this->entityManager->persist($customer);
            }

            $customer->firstname = $customerModel->firstname;
            $customer->lastname = $customerModel->lastname;
            $customer->email = $customerModel->email;
            $customer->country = $customerModel->country;
            $customer->username = $customerModel->username;
            $customer->gender = $customerModel->gender;
            $customer->city = $customerModel->city;
            $customer->phone = $customerModel->phone;

            if (($counter % self::BATCH_SIZE) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
