<?php

namespace Acme;

//SOLID Principles - part2 - Open/closed
class Square implements ShapeInterface {
    public $width;
    public $height;

    function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }


    public function area()
    {
        // TODO: Implement area() method.
        return $this->width * $this->height;
    }
}