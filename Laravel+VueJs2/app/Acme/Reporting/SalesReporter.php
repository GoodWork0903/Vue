<?php

namespace Acme\Reporting;

use Exception;
use Illuminate\Support\Facades\Auth;
use Acme\Repositories\SalesRepository;


//Solid Principle - 1part - Single responsibility principle
class SalesReporter {

    private $repo;

    public function __construct(SalesRepository $repo)
    {
        $this->repo = $repo;
    }


    public function between($start_date, $end_date, SalesOutputInterface $formatter) {

		//perform auth
        if (!Auth::check()) throw new Exception('Authentication required for reporting');

        //get sales from db
        $sales = $this->repo->between($start_date, $end_date);

        return $formatter->output($sales);

	}


}