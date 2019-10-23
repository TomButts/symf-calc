<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/calculator", name="calculator_")
 */
class CalculatorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('calculator.html.twig', [ 'current' => '' ]);
    }

    /**
     * @Route("/append/{value}", name="append")
     */
    public function append($value)
    {
        echo '<pre>';
        print_r('hi');
        echo '</pre>';
        die();
    }

    /**
     * @Route("/operand/{value}", name="operand")
     */
    public function operand($value)
    {

    }

    /**
     * @Route("/updateCurrent/{operation}", name="updateCurrent")
     */
    public function updateCurrent($operation)
    {

    }

    /**
     * @Route("/equal", name="equal")
     */
    public function equal()
    {

    }

    /**
     * @Route("/clear", name="clear")
     */
    public function clear()
    {

    }

    /**
     * @Route("/save", name="save")
     */
    public function save()
    {

    }
}
