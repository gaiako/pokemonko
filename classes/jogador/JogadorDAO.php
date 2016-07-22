<?php
	class JogadorDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($jogador){
			$comando = 'insert into jogador (id, nome, humano, dificuldade, idGravacao, idMapa, x, y, cor, dinheiro) values (:id, :nome, :humano, :dificuldade, :idGravacao, :idMapa, :x, :y, :cor, :dinheiro)';
			$this->getBancoDados()->executar($comando, $this->parametros($jogador));
		}

		protected function atualizar($jogador){
			$comando = 'update jogador set nome = :nome, humano = :humano, dificuldade = :dificuldade, idGravacao = :idGravacao, idMapa = :idMapa, x = :x, y = :y, cor = :cor, dinheiro = :dinheiro where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($jogador));
		}

		protected function parametros($jogador){
			return array(
				'id' => $jogador->getId(),
				'nome' => $jogador->getNome(),
				'humano' => $jogador->getHumano(),
				'dificuldade' => $jogador->getDificuldade(),
				'idGravacao' => $jogador->getGravacao()->getId(),
				'idMapa' => $jogador->getMapa()->getId(),
				'x' => $jogador->getX(),
				'y' => $jogador->getY(),
				'cor' => $jogador->getCor(),
				'dinheiro' => $jogador->getDinheiro()
			);
		}

		public function existe($jogador){
			/*if($this->getBancoDados()->existe('jogador', 'nome', $jogador->getNome(), $jogador->getId()))
				return true;
			return false;*/
		}

		public function transformarEmObjeto($l, $completo = true){
			$jogador = new Jogador();
			$jogador->setId($l['id']);
			$jogador->setNome($l['nome']);
			$jogador->setHumano($l['humano']);
			$jogador->setDificuldade($l['dificuldade']);
			if($completo){
				$gravacao = Util::makeDao('gravacao')->obterComId($l['idGravacao'],false);
				$jogador->setGravacao($gravacao);
				
				$mapa = Util::makeDao('mapa')->obterComId($l['idMapa']);
				$jogador->setMapa($mapa);
			}
			$jogador->setX($l['x']);
			$jogador->setY($l['y']);
			$jogador->setCor($l['cor']);
			$jogador->setDinheiro($l['dinheiro']);
			return $jogador;
		}

		public function obterTodos($orderBy = 'jogador.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from jogador where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select * from jogador where id = :id';
			$parametros = array(
				'id' => $id
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, $completo);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('jogador', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('jogador', $id);
		}
	}
?>