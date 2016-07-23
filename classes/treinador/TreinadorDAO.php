<?php
	class TreinadorDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($treinador){
			$comando = 'insert into treinador (nome, humano, dificuldade, idGravacao, idMapa, x, y, cor, dinheiro) values (:nome, :humano, :dificuldade, :idGravacao, :idMapa, :x, :y, :cor, :dinheiro)';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador));
		}

		protected function atualizar($treinador){
			$comando = 'update treinador set nome = :nome, humano = :humano, dificuldade = :dificuldade, idGravacao = :idGravacao, idMapa = :idMapa, x = :x, y = :y, cor = :cor, dinheiro = :dinheiro where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador,true));
		}

		protected function parametros($treinador,$update = false){
			$parametros = array(
				'nome' => $treinador->getNome(),
				'humano' => $treinador->getHumano(),
				'dificuldade' => $treinador->getDificuldade(),
				'idGravacao' => $treinador->getGravacao()->getId(),
				'idMapa' => $treinador->getMapa()->getId(),
				'x' => $treinador->getX(),
				'y' => $treinador->getY(),
				'cor' => $treinador->getCor(),
				'dinheiro' => $treinador->getDinheiro()
			);
			if($update)
				$parametros['id'] = $treinador->getId();
			return $parametros;
		}

		public function existe($treinador){
			/*if($this->getBancoDados()->existe('treinador', 'nome', $treinador->getNome(), $treinador->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$treinador = new Treinador();
			$treinador->setId($l['id']);
			$treinador->setNome($l['nome']);
			$treinador->setHumano($l['humano']);
			$treinador->setDificuldade($l['dificuldade']);
			if($completo){
				$gravacao = Util::makeDao('gravacao')->obterComId($l['idGravacao'],false);
				$treinador->setGravacao($gravacao);
				
				$mapa = Util::makeDao('mapa')->obterComId($l['idMapa']);
				$treinador->setMapa($mapa);
			}
			$treinador->setX($l['x']);
			$treinador->setY($l['y']);
			$treinador->setCor($l['cor']);
			$treinador->setDinheiro($l['dinheiro']);
			return $treinador;
		}

		public function obterTodos($orderBy = 'treinador.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from treinador where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from treinador where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('treinador', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('treinador', $id);
		}
	}
?>