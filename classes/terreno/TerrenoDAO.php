<?php
	class TerrenoDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($terreno){
			$comando = 'insert into terreno (nome, cor, bloqueadoUp, bloqueadoLeft, bloqueadoRight, bloqueadoDown) values (:nome, :cor, :bloqueadoUp, :bloqueadoLeft, :bloqueadoRight, :bloqueadoDown)';
			$this->getBancoDados()->executar($comando, $this->parametros($terreno));
		}

		protected function atualizar($terreno){
			$comando = 'update terreno set nome = :nome, cor = :cor, bloqueadoUp = :bloqueadoUp, bloqueadoLeft = :bloqueadoLeft, bloqueadoRight = :bloqueadoRight, bloqueadoDown = :bloqueadoDown where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($terreno,true));
		}

		protected function parametros($terreno,$update = false){
			$parametros = array(
				'nome' => $terreno->getNome(),
				'cor' => $terreno->getCor(),
				'bloqueadoUp' => $terreno->getBloqueadoUp(),
				'bloqueadoLeft' => $terreno->getBloqueadoLeft(),
				'bloqueadoRight' => $terreno->getBloqueadoRight(),
				'bloqueadoDown' => $terreno->getBloqueadoDown()
			);
			if($update)
				$parametros['id'] = $terreno->getId();
			return $parametros;
		}

		public function existe($terreno){
			/*if($this->getBancoDados()->existe('terreno', 'nome', $terreno->getNome(), $terreno->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$terreno = new Terreno();
			$terreno->setId($l['id']);
			$terreno->setNome($l['nome']);
			$terreno->setImagem($l['imagem']);
			$terreno->setCor($l['cor']);
			$terreno->setBloqueadoUp($l['bloqueadoUp']);
			$terreno->setBloqueadoLeft($l['bloqueadoLeft']);
			$terreno->setBloqueadoRight($l['bloqueadoRight']);
			$terreno->setBloqueadoDown($l['bloqueadoDown']);
			return $terreno;
		}

		public function obterTodos($orderBy = 'terreno.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from terreno where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from terreno where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('terreno', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('terreno', $id);
		}
	}
?>