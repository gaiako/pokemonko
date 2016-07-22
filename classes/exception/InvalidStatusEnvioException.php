<?php
class InvalidStatusEnvioException extends RuntimeException {
    public function __construct($status) {
    	parent::__construct("Status invalido de envio do pedido: $status!");
    }
}

?>