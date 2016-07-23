<?php
	class MapaDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($mapa){
			$comando = 'insert into mapa (id, nome, dimensaoX, dimensaoY, terrenoPadrao, xInicial, yInicial) values (:id, :nome, :dimensaoX, :dimensaoY, :terrenoPadrao, :xInicial, :yInicial)';
			$this->getBancoDados()->executar($comando, $this->parametros($mapa));
		}

		protected function atualizar($mapa){
			$comando = 'update mapa set nome = :nome, dimensaoX = :dimensaoX, dimensaoY = :dimensaoY, terrenoPadrao = :terrenoPadrao, xInicial = :xInicial, yInicial = :yInicial where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($mapa,true));
		}

		protected function parametros($mapa,$update = false){
			$parametros = array(
				'id' => $mapa->getId(),
				'nome' => $mapa->getNome(),
				'dimensaoX' => $mapa->getDimensaoX(),
				'dimensaoY' => $mapa->getDimensaoY(),
				'terrenoPadrao' => $mapa->getTerrenoPadrao()->getId(),
				'xInicial' => $mapa->getXInicial(),
				'yInicial' => $mapa->getYInicial()
			);
			if($update)
				$parametros['id'] = $treinador->getId();
			return $parametros;
		}

		public function existe($mapa){
			/*if($this->getBancoDados()->existe('mapa', 'nome', $mapa->getNome(), $mapa->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$mapa = new Mapa();
			$mapa->setId($l['id']);
			$mapa->setNome($l['nome']);
			$mapa->setDimensaoX($l['dimensaoX']);
			$mapa->setDimensaoY($l['dimensaoY']);
			$mapa->setTerrenoPadrao($l['terrenoPadrao']);
			$mapa->setXInicial($l['xInicial']);
			$mapa->setYInicial($l['yInicial']);
			return $mapa;
		}

		public function obterTodos($orderBy = 'mapa.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from mapa where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from mapa where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('mapa', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('mapa', $id);
		}
	}
?>