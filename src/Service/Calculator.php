<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Calculator
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();        
    }

    public function persist()
    {
        $this->session->set('calculator', 'hi');
        dump($this->session->geta('calculator'));

        // Check session for calc
        // if not add db row and put into sesh
        // else just return the calculator instance

        // if (!$request->session()->has('calculator')) {
        //     $calculator = Calculator::create([
        //         'current' => '',
        //         'previous' => '',
        //         'operand' => '',
        //         'memory' => ''
        //     ]);
        //     $request->session()->put('calculator', $calculator->id);
        // }
        // $calculator = Calculator::find($request->session()->get('calculator'));
        // if (!$calculator) {
        //     $request->session()->forget('calculator');
        // }
    }
}
