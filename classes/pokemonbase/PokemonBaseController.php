<?php
	class PokemonBaseController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'hp', 'ataque', 'defesa', 'agilidade', 'especial', 'exp', 'sortePokeball', 'nivel', 'raridade');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$pokemonBase = new PokemonBase();
			$this->povoarSimples($pokemonBase, $todosOsCampos, $_POST);
			
			$tipoController = Util::makeController('tipo');
			$tipo = $tipoController->obterComId($_POST['tipo']);
			$pokemonBase->setTipo($tipo);
			
			if(is_numeric($_POST['tipo2'])){
				$pokemonBase->setTipo2($tipoController->obterComId($_POST['tipo2']));
			}
			
			return $pokemonBase;
		}
	}
?>