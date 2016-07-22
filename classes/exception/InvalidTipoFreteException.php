<?php
class InvalidTipoFreteException extends RuntimeException {
    public function __construct($status) {
    	parent::__construct("Tipo de frete invalido: $status!");
    }
}

?>