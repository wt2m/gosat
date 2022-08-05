<?php
    namespace App\Utils;

    class MethodUtils {
        function validateCPF($cpf) {

            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

            if (strlen($cpf) != 11) {
                return false;
            }
 
            /*
                TODO:
                    Implement CPF calculation and non-unique number validation
                    Hello gosat dev :)
            */

            return true;
        
        }
    }