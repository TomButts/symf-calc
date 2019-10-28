<?php

namespace App\Service;

use Exception;

use App\Entity\Calculator as CalculatorEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Calculator
{
    protected $calculatorEntity;

    protected $entityManager;

    protected $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;

        $this->persist();
    }

    public function persist()
    {
        $calculatorId = $this->session->get('calculator');

        if (!$calculatorId) {
            // Persist calculator data
            $calculator = new CalculatorEntity();
            $this->entityManager->persist($calculator);
            $this->entityManager->flush();

            $calculatorId = $calculator->getId();

            // Set calculator id in session
            $this->session->set('calculator', $calculatorId);
        }

        // Use session id to get calculator instance
        $calculator = $this->entityManager
            ->getRepository(CalculatorEntity::class)
            ->find($calculatorId);

        if (!$calculator) {
            // Reset session to fetch new calculator next request
            $this->session->set('calculator', '');

            throw new Exception('Calculator not found.');
        }

        $this->calculatorEntity = $calculator;

        return $calculator;
    }

    public function equal($nextOperation = '')
    {
        $current = $this->calculatorEntity->getCurrent();
        $previous = $this->calculatorEntity->getPrevious();

        switch ($this->calculatorEntity->getOperand()) {
            case 'add':
                $current = (float) $previous + (float) $current;
                break;
            case 'minus':
                $current = (float) $previous - (float) $current;
                break;
            case 'multiply':
                $current = (float) $previous * (float) $current;
                break;
            case 'divide':
                if (!$previous || !$current) {
                    $current = 0;
                }
                $current = (float) $previous / (float) $current;
                break;
            default:
                throw new Exception('Operation not recognised in equals.');
                break;
        }

        $this->calculatorEntity->setCurrent($current);
        $this->calculatorEntity->setPrevious(($nextOperation !== '') ? $current : '');
        $this->calculatorEntity->setOperand($nextOperation);
        $this->calculatorEntity->setOperandActive(($nextOperation !== '') ? true : false);

        $this->entityManager->persist($this->calculatorEntity);
        $this->entityManager->flush();

        return $this->calculatorEntity;
    }

    /**
     * Handle appending a value to the calculator
     *
     * @param $value
     */
    public function append($value)
    {
        $current = $this->calculatorEntity->getCurrent();

        $this->calculatorEntity->setCurrent($current . $value);

        if ($this->calculatorEntity->getOperandActive()) {
            $this->calculatorEntity->setOperandActive(false);
            $this->calculatorEntity->setCurrent($value);
        }

        $this->entityManager->persist($this->calculatorEntity);
        $this->entityManager->flush();
    }

    public function setOperand($value)
    {
        $this->calculatorEntity->setPrevious($this->calculatorEntity->getCurrent());
        $this->calculatorEntity->setOperand($value);
        $this->calculatorEntity->setOperandActive(true);

        $this->entityManager->persist($this->calculatorEntity);
        $this->entityManager->flush();

        return $this->calculatorEntity;
    }

    public function updateCurrent($operation)
    {
        $current = $this->calculatorEntity->getCurrent();

        switch ($operation) {
            case 'percent':
                $current = (float) $current / 100;
                break;
            case 'sign':
                if (substr($current, 0, 1) === '-') {
                    $current = ltrim($current, '-');
                } else {
                    $current = '-' . $current;
                }
                break;
            case 'point':
                if (strpos($current, '.') === false) {
                    $current .= '.';
                }
                break;

            default:
                throw new Exception('Operation name not recognised!');
                break;
        }

        $this->calculatorEntity->setCurrent($current);

        $this->entityManager->persist($this->calculatorEntity);
        $this->entityManager->flush();

        return $this->calculatorEntity;
    }

    public function clear()
    {
        $this->calculatorEntity->setCurrent('');
        $this->calculatorEntity->setPrevious('');
        $this->calculatorEntity->setOperand('');
        $this->calculatorEntity->setOperandActive(false);

        $this->entityManager->persist($this->calculatorEntity);
        $this->entityManager->flush();
    }
}
