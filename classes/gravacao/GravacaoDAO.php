<?php
	class GravacaoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($gravacao){
			$comando = 'insert into gravacao (nome, dataCadastro) values (:nome, now())';
			$this->getBancoDados()->executar($comando, $this->parametros($gravacao));
			$id = $this->getBancoDados()->ultimoId();
			$gravacao->setId($id);
			
			$this->salvarTreinadores($gravacao);
		}

		protected function atualizar($gravacao){
			$comando = 'update gravacao set nome = :nome where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($gravacao,true));
		}
		
		public function salvarTreinadores($gravacao){
			foreach($gravacao->getTreinadores() as $treinador){
				$comando = "insert into treinador_gravacao (idTreinador,idGravacao,idMapa,x,y) values (:idTreinador,:idGravacao,:idMapa,:x,:y)";
				$parametros = array(
					'idTreinador' => $treinador->getId(),
					'idGravacao' => $gravacao->getId(),
					'idMapa' => $gravacao->getMapaInicial()->getId(),
					'x' => $gravacao->getMapaInicial()->getXInicial(),
					'y' => $gravacao->getMapaInicial()->getYInicial()
				);
				$this->getBancoDados()->executar($comando,$parametros);
			}
		}

		protected function parametros($gravacao,$update = false){
			$parametros = array(
				'nome' => $gravacao->getNome()
			);
			if($update)
				$parametros['id'] = $gravacao->getId();
			return $parametros;
		}

		public function existe($gravacao){
			/*if($this->getBancoDados()->existe('gravacao', 'nome', $gravacao->getNome(), $gravacao->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$gravacao = new Gravacao();
			$gravacao->setId($l['id']);
			$gravacao->setNome($l['nome']);
			$gravacao->setDataCadastro($l['dataCadastro']);
			
			if($completo){
				$treinadores = Util::makeDao('treinador')->obterComGravacao($gravacao);
				$gravacao->setTreinadores($treinadores);
			}
			
			return $gravacao;
		}
		
		public function passarAVez($idJogador){
			
		}

		public function obterTodos($orderBy = 'gravacao.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from gravacao where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from gravacao where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('gravacao', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('gravacao', $id);
		}
	}
?>