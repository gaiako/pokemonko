<?php
class InvalidStatusPedidoTransitionException extends RuntimeException {
    public function __construct($cur, $next) {
    	parent::__construct("Transição de status do pedido invalido: $cur -> $next!");
    }
}

?>