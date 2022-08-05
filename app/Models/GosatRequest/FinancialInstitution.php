<?php
    namespace App\Models\GosatRequest;

class FinancialInstitution
{
    public $id;
    public $name;
    public $modalities;

    function __construct($id, $name, $modalities){
        $this->id            = $id;
        $this->name            = $name;
        $this->modalities       = [];
        foreach($modalities as $modality){
            array_push($this->modalities, new Modality($modality->nome, $modality->cod));
        }
    }
}