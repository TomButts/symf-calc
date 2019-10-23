<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalculatorRepository")
 */
class Calculator
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $current;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $previous;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $operand;

    /**
     * @ORM\Column(type="boolean")
     */
    private $operandActive = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $memory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrent(): ?string
    {
        return $this->current;
    }

    public function setCurrent(?string $current): self
    {
        $this->current = $current;

        return $this;
    }

    public function getPrevious(): ?string
    {
        return $this->previous;
    }

    public function setPrevious(?string $previous): self
    {
        $this->previous = $previous;

        return $this;
    }

    public function getOperand(): ?string
    {
        return $this->operand;
    }

    public function setOperand(?string $operand): self
    {
        $this->operand = $operand;

        return $this;
    }

    public function getOperandActive(): ?bool
    {
        return $this->operandActive;
    }

    public function setOperandActive(bool $operandActive): self
    {
        $this->operandActive = $operandActive;

        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(?string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }
}
