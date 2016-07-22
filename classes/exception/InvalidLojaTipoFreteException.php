<?php
class InvalidLojaTipoFreteException extends RuntimeException {
    public function __construct($tipo) {
    	parent::__construct("Tipo de frete para loja invalido: $tipo!");
    }
}
?>