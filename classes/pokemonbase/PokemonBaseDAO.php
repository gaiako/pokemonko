<?php
	class PokemonBaseDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($pokemonBase){
			$comando = 'insert into pokemon_base (nome, idTipo, idTipo2, hp, ataque, defesa, agilidade, ataqueEspecial, defesaEspecial, exp, sortePokeball, nivel, raridade) values (:nome, :idTipo, :idTipo2, :hp, :ataque, :defesa, :agilidade, :ataqueEspecial, :defesaEspecial, :exp, :sortePokeball, :nivel, :raridade)';
			$this->getBancoDados()->executar($comando, $this->parametros($pokemonBase));
		}

		protected function atualizar($pokemonBase){
			$comando = 'update pokemon_base set nome = :nome, idTipo = :idTipo, idTipo2 = :idTipo2, hp = :hp, ataque = :ataque, defesa = :defesa, agilidade = :agilidade, ataqueEspecial = :ataqueEspecial, defesaEspecial = :defesaEspecial, exp = :exp, sortePokeball = :sortePokeball, nivel = :nivel, raridade = :raridade where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($pokemonBase,true));
		}

		protected function parametros($pokemonBase,$update = false){
			$parametros = array(
				'nome' => $pokemonBase->getNome(),
				'idTipo' => $pokemonBase->getTipo()->getId(),
				'idTipo2' => ($pokemonBase->getTipo2() instanceOf Tipo) ? $pokemonBase->getTipo2()->getId() : null,
				'hp' => $pokemonBase->getHp(),
				'ataque' => $pokemonBase->getAtaque(),
				'defesa' => $pokemonBase->getDefesa(),
				'agilidade' => $pokemonBase->getAgilidade(),
				'ataqueEspecial' => $pokemonBase->getAtaqueEspecial(),
				'defesaEspecial' => $pokemonBase->getDefesaEspecial(),
				'exp' => $pokemonBase->getExp(),
				'sortePokeball' => $pokemonBase->getSortePokeball(),
				'nivel' => $pokemonBase->getNivel(),
				'raridade' => $pokemonBase->getRaridade()
			);
			if($update)
				$parametros['id'] = $pokemonBase->getId();
			return $parametros;
		}

		public function existe($pokemonBase){
			/*if($this->getBancoDados()->existe('pokemon_base', 'nome', $pokemonBase->getNome(), $pokemonBase->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$pokemonBase = new PokemonBase();
			$pokemonBase->setId($l['id']);
			$pokemonBase->setNome($l['nome']);
			
			$pokemonBase->setTipo(Util::makeDao('tipo')->obterComId($l['idTipo']));
			if(is_numeric($l['idTipo2']))
				$pokemonBase->setTipo2(Util::makeDao('tipo')->obterComId($l['idTipo2']));
			
			$pokemonBase->setHp($l['hp']);
			$pokemonBase->setAtaque($l['ataque']);
			$pokemonBase->setDefesa($l['defesa']);
			$pokemonBase->setAgilidade($l['agilidade']);
			$pokemonBase->setAtaqueEspecial($l['ataqueEspecial']);
			$pokemonBase->setDefesaEspecial($l['defesaEspecial']);
			$pokemonBase->setExp($l['exp']);
			$pokemonBase->setSortePokeball($l['sortePokeball']);
			$pokemonBase->setNivel($l['nivel']);
			$pokemonBase->setRaridade($l['raridade']);
			return $pokemonBase;
		}
		
		public function obterAleatoriamente($nivel){
			$sorte = rand(1,100);
			if($sorte < 15)
				$nivel --;
			if($sorte > 95){
				$nivel++;
				$sorteUltra = rand(1,100);
				if($sorteUltra == 100)
					$nivel++;
			}
			if($nivel < 1)
				$nivel = 1;
			
			$raridade = rand(1,100);
			
			$comando = "select * from pokemon_base where nivel = :nivel and raridade <= :raridade";
			$parametros = array(
				'nivel' => $nivel,
				'raridade' => $raridade
			);
			return $this->getBancoDados()->obterObjetos($comando,array($this,'transformarEmObjeto'),$parametros, 'rand()', 1);
		}
		
		public function obterOrdenadosPorForca(){
			$comando = "
			select id,hp+ataque+defesa+agilidade+ataqueEspecial+defesaEspecial as total 
			from pokemon_base 
			";
			return $this->getBancoDados()->obterObjetos($comando,array($this,'transformarEmObjeto'),array(),'total');
		}
		
		public function obterPokemonsDoGrupo(&$grupo){
			$comando = "select idPokemon from grupo_pokemon where idGrupo = :idGrupo";
			$parametros = array(
				'idGrupo' => $grupo->getId()
			);
			$linhas = $this->getBancoDados()->consultar($comando,$parametros);
			
			foreach($linhas as $l){
				$pokemon = $this->obterComId($l['idPokemon']);
				$grupo->addPokemon($pokemon);
			}
		}

		public function obterTodos($orderBy = 'pokemonBase.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from pokemon_base where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando,array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from pokemon_base where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('pokemon_base', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('pokemon_base', $id);
		}
	}
?>