<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customers')]
class CustomerController extends AbstractController
{
    #[Route('')]
    public function list(CustomerRepository $customerRepository): Response
    {
        return $this->json(data: $customerRepository->findAll(), context: [
            'groups' => ['list'],
        ]);
    }

    #[Route('/{id}')]
    public function show(Customer $customer): Response
    {
        return $this->json(data: $customer, context: [
            'groups' => ['item'],
        ]);
    }
}
