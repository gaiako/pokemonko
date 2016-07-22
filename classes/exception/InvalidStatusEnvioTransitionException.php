<?php
class InvalidStatusEnvioTransitionException extends RuntimeException {
    public function __construct($cur, $next) {
		parent::__construct("Transição status envio do pedido inválido: $cur -> $next!");
    }
}

?>