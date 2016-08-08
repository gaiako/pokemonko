<?php
	class AtaqueController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'json', 'descricao', 'categoria', 'tipo', 'dano', 'recuperacao', 'precisao', 'sempreAcerta', 'prioridade', 'numeroAtaques', 'idEfeito', 'precisaoEfeito', 'habilitado');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$ataque = new Ataque();
			$this->povoarSimples($ataque, $todosOsCampos, $_POST);
			return $ataque;
		}
		
		public function sortearAtaques($pokemon){
			return Util::makeService($this->classe)->sortearAtaques($pokemon);
		}
		
		public function obterOutrosAtaques($pokemon){
			return Util::makeService($this->classe)->obterOutrosAtaques($pokemon);
		}
	}
?>