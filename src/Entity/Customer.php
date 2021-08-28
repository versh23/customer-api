<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customers')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list', 'item'])]
    public ?int $id;

    #[ORM\Column]
    public string $firstname;

    #[ORM\Column]
    public string $lastname;

    #[ORM\Column(unique: true)]
    #[Groups(['list', 'item'])]
    public string $email;

    #[ORM\Column]
    #[Groups(['item'])]
    public string $username;

    #[ORM\Column]
    #[Groups(['item'])]
    public string $gender;

    #[ORM\Column]
    #[Groups(['item'])]
    public string $city;

    #[ORM\Column]
    #[Groups(['item'])]
    public string $phone;

    #[ORM\Column]
    #[Groups(['list', 'item'])]
    public string $country;

    #[Groups(['list', 'item'])]
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstname, $this->lastname);
    }
}
