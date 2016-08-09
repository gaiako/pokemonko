<?php
	class GrupoController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'minNivel', 'maxNivel');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$grupo = new Grupo();
			$this->povoarSimples($grupo, $todosOsCampos, $_POST);
			
			if(isset($_POST['pokemons'])){
				$grupo->setPokemons(Util::makeController('pokemonBase')->obterComIds($_POST['pokemons']));
			}
			
			return $grupo;
		}

		public function alterarRaridade($idGrupo,$idPokemon,$raridade){
			return Util::makeService('grupo')->alterarRaridade($idGrupo,$idPokemon,$raridade);
		}
	}
?>