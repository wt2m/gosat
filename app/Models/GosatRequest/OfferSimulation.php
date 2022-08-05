<?php
    namespace App\Models\GosatRequest;

class OfferSimulation 
{
    public $cpf;
    public $institution_id;
    public $cod_modality;

    function __construct($cpf, $institution_id, $cod_modality){
        $this->cpf            = $cpf;
        $this->institution_id = $institution_id;
        $this->cod_modality   = $cod_modality;
    }
}