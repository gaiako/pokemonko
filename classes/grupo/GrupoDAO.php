<?php
	class GrupoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($grupo){
			$comando = 'insert into grupo (nome) values (:nome)';
			$this->getBancoDados()->executar($comando, $this->parametros($grupo));
			$id = $this->getBancoDados()->ultimoId();
			$grupo->setId($id);
			
			$this->salvarPokemonsGrupo($grupo);
		}

		protected function atualizar($grupo){
			$comando = 'update grupo set nome = :nome where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($grupo,true));
			
			$this->salvarPokemonsGrupo($grupo);
		}

		protected function parametros($grupo,$update = false){
			$parametros = array(
				'nome' => $grupo->getNome()
			);
			if($update)
				$parametros['id'] = $grupo->getId();
			return $parametros;
		}

		public function existe($grupo){
			/*if($this->getBancoDados()->existe('grupo', 'nome', $grupo->getNome(), $grupo->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$grupo = new Grupo();
			$grupo->setId($l['id']);
			$grupo->setNome($l['nome']);
			
			if($completo){
				Util::makeDao('pokemonBase')->obterPokemonsDoGrupo($grupo);
			}
			return $grupo;
		}
		
		public function salvarPokemonsGrupo($grupo){
			$this->excluirPokemonsDoGrupo($grupo);
			foreach($grupo->getPokemons() as $pokemon){
				$comando = "insert into grupo_pokemon (idGrupo,idPokemon) values (:idGrupo,:idPokemon)";
				$parametros = array(
					'idGrupo' => $grupo->getId(),
					'idPokemon' => $pokemon->getId()
				);
				$this->getBancoDados()->executar($comando,$parametros);
			}
		}
		
		public function excluirPokemonsDoGrupo($grupo){
			$comando = "delete from grupo_pokemon where idGrupo = :idGrupo";
			$parametros = array(
				'idGrupo' => $grupo->getId()
			);
			return $this->getBancoDados()->executar($comando,$parametros);
		}

		public function obterTodos($orderBy = 'grupo.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from grupo where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from grupo where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('grupo', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('grupo', $id);
		}
	}
?>