<?php
	class ObjetoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($objeto){
			$comando = 'insert into objeto (nome) values (:nome)';
			$this->getBancoDados()->executar($comando, $this->parametros($objeto));
		}

		protected function atualizar($objeto){
			$comando = 'update objeto set nome = :nome where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($objeto,true));
		}

		protected function parametros($objeto,$update = false){
			$parametros = array(
				'nome' => $objeto->getNome()
			);
			if($update)
				$parametros['id'] = $objeto->getId();
			return $parametros;
		}

		public function existe($objeto){
			/*if($this->getBancoDados()->existe('objeto', 'nome', $objeto->getNome(), $objeto->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$objeto = new Objeto();
			$objeto->setId($l['id']);
			$objeto->setNome($l['nome']);
			return $objeto;
		}

		public function obterTodos($orderBy = 'objeto.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from objeto where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from objeto where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('objeto', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('objeto', $id);
		}
	}
?>