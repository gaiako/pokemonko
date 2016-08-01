<?php
	class PokemonController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'idTreinadorGravacao', 'idMapa', 'idGrupo', 'looking', 'x', 'y', 'hp', 'ataque', 'defesa', 'ataqueEspecial', 'defesaEspecial', 'agilidade', 'exp', 'nivel', 'ativo');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$pokemon = new Pokemon();
			$this->povoarSimples($pokemon, $todosOsCampos, $_POST);
			
			return $pokemon;
		}
		
		public function criarAPartirDeBase($pokemonBase,$mapaPixel = null){
			global $erro;
			$pokemon = new Pokemon();
			
			$grupo = Util::makeController('grupo')->obterComId($mapaPixel['idGrupo']);
			$nivel = rand($grupo->getMinNivel(),$grupo->getMaxNivel());
			
			$pokemon->setPokemonBase($pokemonBase);
			$pokemon->setIdMapa($mapaPixel['idMapa']);
			$pokemon->setIdGrupo($mapaPixel['idGrupo']);
			$pokemon->setX($mapaPixel['x']);
			$pokemon->setY($mapaPixel['y']);
			$pokemon->setHp($pokemonBase->getHp()+($nivel*2));
			$pokemon->setAtaque($pokemonBase->getAtaque()+($nivel*2));
			$pokemon->setDefesa($pokemonBase->getDefesa()+($nivel*2));
			$pokemon->setAtaqueEspecial($pokemonBase->getAtaqueEspecial()+($nivel*2));
			$pokemon->setDefesaEspecial($pokemonBase->getDefesaEspecial()+($nivel*2));
			$pokemon->setAgilidade($pokemonBase->getAgilidade()+($nivel*2));
			$pokemon->setNivel($nivel);
			$pokemon->setLooking(Looking::sortear());
			
			$pokemon->setAtaques(Util::makeController('ataque')->sortearAtaques($pokemon));
			
			return $this->salvar($pokemon,$erro);
		}
		
		public function obterComRestricoes($restricoes,$orderBy = 'pokemon.id', $limit = null, $offset = null, $completo = true){
			return Util::makeService($this->classe)->obterComRestricoes($restricoes,$orderBy, $limit, $offset, $completo);
		}
	}
?>