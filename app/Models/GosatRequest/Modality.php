<?php
namespace App\Models\GosatRequest;

class Modality
{
    public $name;
    public $code;

    function __construct($name, $code){
        $this->code            = $code;
        $this->name            = $name;
    }
}