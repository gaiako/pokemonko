<?php
	class AtaqueDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($ataque){
			$comando = 'insert into ataque (id, nome, json, descricao, categoria, tipo, dano, recuperacao, precisao, sempreAcerta, prioridade, numeroAtaques, idEfeito, precisaoEfeito, habilitado) values (:id, :nome, :json, :descricao, :categoria, :tipo, :dano, :recuperacao, :precisao, :sempreAcerta, :prioridade, :numeroAtaques, :idEfeito, :precisaoEfeito, :habilitado)';
			$this->getBancoDados()->executar($comando, $this->parametros($ataque));
		}

		protected function atualizar($ataque){
			$comando = 'update ataque set nome = :nome, json = :json, descricao = :descricao, categoria = :categoria, tipo = :tipo, dano = :dano, recuperacao = :recuperacao, precisao = :precisao, sempreAcerta = :sempreAcerta, prioridade = :prioridade, numeroAtaques = :numeroAtaques, idEfeito = :idEfeito, precisaoEfeito = :precisaoEfeito, habilitado = :habilitado where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($ataque));
		}

		protected function parametros($ataque){
			return array(
				'id' => $ataque->getId(),
				'nome' => $ataque->getNome(),
				'json' => $ataque->getJson(),
				'descricao' => $ataque->getDescricao(),
				'categoria' => $ataque->getCategoria(),
				'tipo' => $ataque->getTipo(),
				'dano' => $ataque->getDano(),
				'recuperacao' => $ataque->getRecuperacao(),
				'precisao' => $ataque->getPrecisao(),
				'sempreAcerta' => $ataque->getSempreAcerta(),
				'prioridade' => $ataque->getPrioridade(),
				'numeroAtaques' => $ataque->getNumeroAtaques(),
				'idEfeito' => $ataque->getIdEfeito(),
				'precisaoEfeito' => $ataque->getPrecisaoEfeito(),
				'habilitado' => $ataque->getHabilitado()
			);
		}

		public function existe($ataque){
			/*if($this->getBancoDados()->existe('ataque', 'nome', $ataque->getNome(), $ataque->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$ataque = new Ataque();
			$ataque->setId($l['id']);
			$ataque->setNome($l['nome']);
			$ataque->setJson($l['json']);
			$ataque->setDescricao($l['descricao']);
			$ataque->setCategoria($l['categoria']);
			$ataque->setTipo($l['tipo']);
			$ataque->setDano($l['dano']);
			$ataque->setRecuperacao($l['recuperacao']);
			$ataque->setPrecisao($l['precisao']);
			$ataque->setSempreAcerta($l['sempreAcerta']);
			$ataque->setPrioridade($l['prioridade']);
			$ataque->setNumeroAtaques($l['numeroAtaques']);
			$ataque->setIdEfeito($l['idEfeito']);
			$ataque->setPrecisaoEfeito($l['precisaoEfeito']);
			$ataque->setHabilitado($l['habilitado']);
			return $ataque;
		}
		
		public function sortearAtaques($pokemon){
			$comando = 'select ataque.* from ataque 
			join pokemonbase_ataque 
				ON pokemonbase_ataque.idAtaque = ataque.id 
				and pokemonbase_ataque.idPokemonBase = :idPokemonBase 
				and pokemonbase_ataque.nivel <= :nivel 
				and ataque.habilitado = 1
			';
			$parametros = array(
				'idPokemonBase' => $pokemon->getPokemonBase()->getId(),
				'nivel' => $pokemon->getNivel()
			);
			return $this->getBancoDados()->obterObjetos($comando,array($this,'transformarEmObjeto'),$parametros,'nivel desc');
		}

		public function obterTodos($orderBy = 'ataque.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from ataque where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from ataque where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('ataque', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('ataque', $id);
		}
	}
?>