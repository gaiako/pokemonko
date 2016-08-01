<?php
	class TreinadorController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'sprite');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$treinador = new Treinador();
			$this->povoarSimples($treinador, $todosOsCampos, $_POST);
			
			if(isset($_POST['humano']))
				$treinador->setHumano(true);
			
			if(isset($_POST['dificuldade']))
				$treinador->setDificuldade($_POST['dificuldade']);
			
			$gravacaoController = Util::makeController('gravacao');
			$treinador->setGravacao($gravacaoController->obterComId($_SESSION['gravacao']));
			
			return $treinador;
		}
		
		public function obterTreinadorDaVez(){
			return Util::makeService($this->classe)->obterTreinadorDaVez();
		}
		
		public function mover($x,$y,$looking){
			return Util::makeService($this->classe)->mover($x,$y,$looking);
		}
	}
?>