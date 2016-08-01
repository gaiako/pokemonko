<?php
	class PokemonDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($pokemon){
			$comando = 'insert into pokemon (idPokemonBase, idTreinadorGravacao, idMapa, idGrupo, looking, x, y, hp, ataque, defesa, ataqueEspecial, defesaEspecial, agilidade, exp, nivel) values (:idPokemonBase, :idTreinadorGravacao, :idMapa, :idGrupo, :looking, :x, :y, :hp, :ataque, :defesa, :ataqueEspecial, :defesaEspecial, :agilidade, :exp, :nivel)';
			$this->getBancoDados()->executar($comando, $this->parametros($pokemon));
			
			$id = $this->getBancoDados()->ultimoId();
			$pokemon->setId($id);
			
			$ataques = serialize($pokemon->getAtaques());
			$pokemon->setAtaques(array());
			$ataques = unserialize($ataques);
			foreach($ataques as $ataque){
				$this->adicionarAtaque($pokemon,$ataque);
			}
			
			return $pokemon;
		}

		protected function atualizar($pokemon){
			$comando = 'update pokemon set idPokemonBase = :idPokemonBase, idTreinadorGravacao = :idTreinadorGravacao, idMapa = :idMapa, idGrupo = :idGrupo, looking = :looking, x = :x, y = :y, hp = :hp, ataque = :ataque, defesa = :defesa, ataqueEspecial = :ataqueEspecial, defesaEspecial = :defesaEspecial, agilidade = :agilidade, exp = :exp, nivel = :nivel where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($pokemon, true));
		}

		protected function parametros($pokemon,$update = false){
			$parametros = array(
				'idPokemonBase' => $pokemon->getPokemonBase()->getId(),
				'idTreinadorGravacao' => $pokemon->getIdTreinadorGravacao(),
				'idMapa' => $pokemon->getIdMapa(),
				'idGrupo' => $pokemon->getIdGrupo(),
				'looking' => $pokemon->getLooking(),
				'x' => $pokemon->getX(),
				'y' => $pokemon->getY(),
				'hp' => $pokemon->getHp(),
				'ataque' => $pokemon->getAtaque(),
				'defesa' => $pokemon->getDefesa(),
				'ataqueEspecial' => $pokemon->getAtaqueEspecial(),
				'defesaEspecial' => $pokemon->getDefesaEspecial(),
				'agilidade' => $pokemon->getAgilidade(),
				'exp' => $pokemon->getExp(),
				'nivel' => $pokemon->getNivel()
			);
			if($update)
				$parametros['id'] = $pokemon->getId();
			return $parametros;
		}

		public function existe($pokemon){
			/*if($this->getBancoDados()->existe('pokemon', 'nome', $pokemon->getNome(), $pokemon->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$pokemon = new Pokemon();
			$pokemon->setId($l['id']);
			$pokemon->setPokemonBase(Util::makeDao('pokemonBase')->obterComId($l['idPokemonBase']));
			$pokemon->setIdTreinadorGravacao($l['idTreinadorGravacao']);
			$pokemon->setIdMapa($l['idMapa']);
			$pokemon->setIdGrupo($l['idGrupo']);
			$pokemon->setLooking($l['looking']);
			$pokemon->setX($l['x']);
			$pokemon->setY($l['y']);
			$pokemon->setHp($l['hp']);
			$pokemon->setAtaque($l['ataque']);
			$pokemon->setDefesa($l['defesa']);
			$pokemon->setAtaqueEspecial($l['ataqueEspecial']);
			$pokemon->setDefesaEspecial($l['defesaEspecial']);
			$pokemon->setAgilidade($l['agilidade']);
			$pokemon->setExp($l['exp']);
			$pokemon->setNivel($l['nivel']);
			return $pokemon;
		}
		
		public function adicionarAtaque($pokemon,$ataque,$topo = false){
			$numAtaques = count($pokemon->getAtaques());
			
			$comando = 'insert into pokemon_ataque (idPokemon,idAtaque,ordem) values (:idPokemon,:idAtaque,:ordem)';
			$numAtaques++;
			if($numAtaques > 4)
				$ordem = null;
			else
				$ordem = $numAtaques;
			$parametros = array(
				'idPokemon' => $pokemon->getId(),
				'idAtaque' => $ataque->getId(),
				'ordem' => $ordem
			);
			$this->getBancoDados()->executar($comando,$parametros);
		}
		
		public function obterComRestricoes($restricoes,$orderBy = 'pokemon.id', $limit = null, $offset = null, $completo = true){
			$select = "select * from pokemon ";
			$join = '';
			$where = '';
			$parametros = array();
			
			if(isset($restricoes['idMapa'])){
				$where .= ' where idMapa = :idMapa';
				$parametros['idMapa'] = $restricoes['idMapa'];
			}
			
			$comando = $select.$join.$where;
			
			return $this->getBancoDados()->obterObjetos($comando,array($this,'transformarEmObjeto'),$parametros,$orderBy,$offset,$completo);
		}

		public function obterTodos($orderBy = 'pokemon.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from pokemon where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from pokemon where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('pokemon', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('pokemon', $id);
			
			$comando = "delete from pokemon_ataque where idPokemon = :idPokemon";
			$parametros['idPokemon'] = $id;
			$this->getBancoDados()->executar($comando,$parametros);
		}
	}
?>