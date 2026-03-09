<?php 

declare(strict_types=1);

class Customer {
   private int $id;
   private string $firstName;
   private string $lastname;
   private string $email;
   private string $address;

   public function __construct(int $id, string $firstName, string $lastname, string $email, string $address)
   {
    $this->id = $id;
    $this->firstName = $firstName;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->address = $address;
   }

   /* getter / setter */

   public function getFirstName(): string
   {
    return $this->firstName;
   }
   public function setFirstName(string $firstName): void
   {
    $this->firstName = $firstName;
   }
   public function getLastName(): string
   {
    return $this->lastname;
   }
   public function setLastName(string $lastname): void
   {
    $this->lastname = $lastname;
   }
   public function getEmail(): string
   {
    return $this->email;
   }
   public function setEmail(string $email): void
   {
    $this->email = $email;
   }
   public function getAddress(): string
   {
    return $this->address;
   }
   public function setAddress(string $address): void
   {
    $this->address = $address;
   }
   public function getFullName(): string
   {
    return "{$this->firstName} {$this->lastname}";
   }
  
   public function __toString():string {
    return "Client #{$this->id}: {$this->getfullName()} ({$this->email}";
   }
}