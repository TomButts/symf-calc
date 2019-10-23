<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/calculator", requirements={"_locale": "en|es|fr"}, name="calculator_")
 */
class CalculatorController extends AbstractController
{
    /**
     * @Route("/{_locale}", name="index")
     */
    public function index()
    {
        return $this->render('calculator.html.twig', [ 'current' => '' ]);
    }

    /**
     * @Route("/{_locale}/append/{value}" name="append")
     */
    public function append($value)
    {

    }

    /**
     * @Route("/{_locale}/operand/{value}" name="operand")
     */
    public function operand($value)
    {

    }

    /**
     * @Route("/{_locale}/updateCurrent/{operation}" name="updateCurrent")
     */
    public function updateCurrent($operation)
    {

    }

    /**
     * @Route("/{_locale}/equal" name="equal")
     */
    public function equal()
    {

    }

    /**
     * @Route("/{_locale}/clear" name="clear")
     */
    public function clear()
    {

    }

    /**
     * @Route("/{_locale}/save" name="save")
     */
    public function save()
    {

    }
}
