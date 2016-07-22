<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/init.php");
	require_once($_->raiz."/util/autoload.php");
	require_once($_->raiz."/classes/BancoDados.php");

	class GravacaoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($gravacao){
			$comando = 'insert into gravacao (id, nome, dataCadastro) values (:id, :nome, now())';
			$this->getBancoDados()->executar($comando, $this->parametros($gravacao));
		}

		protected function atualizar($gravacao){
			$comando = 'update gravacao set nome = :nome where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($gravacao));
		}

		protected function parametros($gravacao){
			return array(
				'id' => $gravacao->getId(),
				'nome' => $gravacao->getNome(),
				'dataCadastro' => $gravacao->getDataCadastro()
			);
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
			$gravacao->setDataCadastro($l['dataCadastro']),
			return $gravacao;
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