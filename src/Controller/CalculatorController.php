<?php

namespace App\Controller;

use Exception;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\Calculator;

/**
 * @Route("/calculator", name="calculator_")
 */
class CalculatorController extends AbstractController
{
    protected $calculator;

    protected $calculatorEntity;

    protected $logger;

    public function __construct(Calculator $calculator, LoggerInterface $logger)
    {
        $this->calculator = $calculator;
        $this->logger = $logger;

        try {
            $this->calculatorEntity = $this->calculator->persist();
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());

            // TODO: Redirect to an error page.
        }
    }

    /**
     * @Route("/", name="index")
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        return $this->render('calculator.html.twig', [
            'current' => $this->calculatorEntity->getCurrent()
        ]);
    }

    /**
     * @Route("/append/{value}", name="append")
     * @param $value
     * @return
     */
    public function append($value)
    {
        $this->calculator->append($value);

        return $this->redirectToRoute('calculator_index');
    }

    /**
     * @Route("/operand/{value}", name="operand")
     * @param $value
     * @return RedirectResponse
     */
    public function operand($value)
    {
        if (
            $this->calculatorEntity->getCurrent() &&
            $this->calculatorEntity->getPrevious() &&
            !$this->calculatorEntity->getOperandActive()
        ) {
            // If its a next operation just redirect to equals
            return $this->redirectToRoute('calculator_equal', [ 'nextOperation' => $value ]);
        }

        // Handle updating all values in the case of a new operand
        $this->calculator->setOperand($value);

        return $this->redirectToRoute('calculator_index');
    }

    /**
     * @Route("/updateCurrent/{operation}", name="updateCurrent")
     * @param $operation
     * @return RedirectResponse
     */
    public function updateCurrent($operation)
    {
        try {
            $this->calculator->updateCurrent($operation);
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage(), [ 'operation' => $operation ]);
        }

        return $this->redirectToRoute('calculator_index');
    }

    /**
     * @Route("/equal", name="equal")
     * @param string $nextOperation
     * @return RedirectResponse
     */
    public function equal($nextOperation = '')
    {
        try {
            $this->calculator->equal($nextOperation);
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        return $this->redirectToRoute('calculator_index');
    }

    /**
     * @Route("/clear", name="clear")
     */
    public function clear()
    {
        $this->calculator->clear();

        return $this->redirectToRoute('calculator_index');
    }

    /**
     * @Route("/save", name="save")
     */
    public function save()
    {

    }
}
