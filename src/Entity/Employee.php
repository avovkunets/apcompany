<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    description: 'Represents an employee in the company',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ]
)]
#[UniqueEntity(fields: ['email'], message: 'This email is already in use.')]
#[ORM\Entity]
class Employee
{
    #[ApiProperty(
        description: 'The unique identifier of the employee',
        example: 1
    )]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(
        description: 'First name of the employee',
        example: 'John'
    )]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'First name is required.')]
    private ?string $firstName = null;

    #[ApiProperty(
        description: 'Last name of the employee',
        example: 'Doe'
    )]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Last name is required.')]
    private ?string $lastName = null;

    #[ApiProperty(
        description: 'Email of the employee',
        example: 'john.doe@example.com'
    )]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $email = null;

    #[ApiProperty(
        description: 'Date when the employee was hired (ISO 8601 format)',
        example: '2025-04-01T00:00:00+00:00'
    )]
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Hired date is required.')]
    #[Assert\GreaterThanOrEqual("today", message: "The hired date cannot be in the past.")]
    private ?\DateTimeImmutable $hiredAt = null;

    #[ApiProperty(
        description: 'Current salary of the employee',
        example: 150.0
    )]
    #[ORM\Column(type: "float")]
    #[Assert\NotBlank(message: 'Salary is required.')]
    #[Assert\GreaterThanOrEqual(value: 100, message: "Salary must be at least 100.")]
    private ?float $salary = null;

    #[ApiProperty(
        description: 'Timestamp when the employee record was created',
        example: '2025-04-01T12:00:00+00:00'
    )]
    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTime $createdAt = null;

    #[ApiProperty(
        description: 'Timestamp when the employee record was last updated',
        example: '2025-04-01T12:05:00+00:00'
    )]
    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getHiredAt(): ?\DateTimeImmutable
    {
        return $this->hiredAt;
    }

    public function setHiredAt(\DateTimeImmutable $hiredAt): self
    {
        $this->hiredAt = $hiredAt;
        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
