<?php
	class TipoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($tipo){
			$comando = 'insert into tipo (id, nome, cor) values (:id, :nome, :cor)';
			$this->getBancoDados()->executar($comando, $this->parametros($tipo));
		}

		protected function atualizar($tipo){
			$comando = 'update tipo set nome = :nome, cor = :cor where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($tipo));
		}

		protected function parametros($tipo){
			return array(
				'id' => $tipo->getId(),
				'nome' => $tipo->getNome(),
				'cor' => $tipo->getCor()
			);
		}

		public function existe($tipo){
			/*if($this->getBancoDados()->existe('tipo', 'nome', $tipo->getNome(), $tipo->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$tipo = new Tipo();
			$tipo->setId($l['id']);
			$tipo->setNome($l['nome']);
			$tipo->setCor($l['cor']);
			return $tipo;
		}

		public function obterTodos($orderBy = 'tipo.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from tipo where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from tipo where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('tipo', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('tipo', $id);
		}
	}
?>