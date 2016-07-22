<?php
class InvalidStatusPedidoException extends RuntimeException {
    public function __construct($status) {
    	parent::__construct("Status invalido do pedido: $status!");
    }
}

?>