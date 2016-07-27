<?php
	class TreinadorDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($treinador){
			$comando = 'insert into treinador (nome, humano, dificuldade, cor) values (:nome, :humano, :dificuldade, :cor)';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador));
		}

		protected function atualizar($treinador){
			$comando = 'update treinador set nome = :nome, humano = :humano, dificuldade = :dificuldade, cor = :cor where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador,true));
		}

		protected function parametros($treinador,$update = false){
			$parametros = array(
				'nome' => $treinador->getNome(),
				'humano' => $treinador->getHumano(),
				'dificuldade' => $treinador->getDificuldade(),
				'cor' => $treinador->getCor()
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
			$treinador->setPokemonDollar($l['pokemonDollar']);
			return $treinador;
		}
		
		public function obterComGravacao($gravacao){
			$comando = "
			SELECT t.nome,tg.idMapa,tg.x,tg.y,tg.pokemonDollar,tg.id 
			FROM treinador t 
			JOIN treinador_gravacao tg 
				ON tg.idTreinador = t.id 
				AND tg.ativo = 1 
				AND tg.idGravacao = :idGravacao
			";
			$parametros = array(
				'idGravacao' => $gravacao->getId()
			);
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'),$parametros,'tg.id');
		}
		
		public function obterComIdEGravacao($idTreinador,$gravacao){
			$comando = "
			SELECT t.nome,tg.idMapa,tg.x,tg.y,tg.pokemonDollar,tg.id 
			FROM treinador t 
			JOIN treinador_gravacao tg 
				ON tg.idTreinador = t.id 
				AND tg.ativo = 1 
				AND tg.idGravacao = :idGravacao 
				AND tg.id = :idTreinador 
			";
			$parametros = array(
				'idGravacao' => $gravacao->getId(),
				'idTreinador' => $idTreinador
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'),$parametros);
		}
		
		public function mover($jogador,$x,$y){
			$comando = "select * from mapa_pixel where x=:x and y=:y and possivelCaminhar = 1";
			$parametros = array(
				'x' => $x,
				'y' => $y
			);
			$mapaPixel = $this->getBancoDados()->consultar($comando,$parametros);
			
			if(!count($mapaPixel))
				Throw new Exception('Não foi possível mover');
			
			$this->atualizarPosicao($x,$y);
			
			$resposta = null;
			if($mapaPixel[0]['aparecePokemon']){
				$sorte = rand(1,100);
				if($sorte >= 1){
					$pokemon = Util::makeDao('pokemonBase')->obterAleatoriamente($mapaPixel[0]['dificuldade']);
					if(count($pokemon)){
						$pokemon[0]->setFoto(str_pad($pokemon[0]->getId(),3,0,STR_PAD_LEFT).'.png');
						$resposta = $pokemon[0];
					}
				}
			}
			return $resposta;
		}
		
		public function atualizarPosicao($x,$y){
			$comando = "update treinador_gravacao set x = :x, y = :y where id = :vezIdTreinador";
			$parametros = array(
				'vezIdTreinador' => $_SESSION['vezIdTreinador'],
				'x' => $x,
				'y' => $y
			);
			$this->getBancoDados()->executar($comando,$parametros);
		}

		public function obterTodos($orderBy = 'treinador.id', $limit = null, $offset = 0, $completo = true){
			$comando = 'select * from treinador where ativo = 1';
			return $this->getBancoDados()->obterObjetos($comando, array($this, 'transformarEmObjeto'), array(), $orderBy, $limit, $offset, $completo);
		}

		public function obterComId($id, $completo = true){
			$comando = 'select treinador.*,tg.idMapa,tg.x,tg.y,tg.pokemonDollar from treinador  
			left join treinador_gravacao tg on tg.idTreinador = treinador.id and tg.idGravacao = :idGravacao and treinador.id = :id';
			$parametros = array(
				'id' => $id,
				'idGravacao' => $_SESSION['gravacao']
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