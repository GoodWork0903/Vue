<?php

namespace Acme\Reporting;

//use Acme\Reporting\SalesOutputInterface;

class HtmlOutput implements SalesOutputInterface {

    public function output($sales)
    {
        // TODO: Implement output() method.
        return "<h1>Sales: $sales</h1>";

    }
}