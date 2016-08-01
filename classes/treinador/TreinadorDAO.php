<?php
	class TreinadorDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($treinador){
			$comando = 'insert into treinador (nome, humano, dificuldade, sprite) values (:nome, :humano, :dificuldade, :sprite)';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador));
		}

		protected function atualizar($treinador){
			$comando = 'update treinador set nome = :nome, humano = :humano, dificuldade = :dificuldade, sprite = :sprite where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($treinador,true));
		}

		protected function parametros($treinador,$update = false){
			$parametros = array(
				'nome' => $treinador->getNome(),
				'humano' => $treinador->getHumano(),
				'dificuldade' => $treinador->getDificuldade(),
				'sprite' => $treinador->getSprite()
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
			$treinador->setSprite($l['sprite']);
			$treinador->setPokemonDollar($l['pokemonDollar']);
			$treinador->setLooking($l['looking']);
			return $treinador;
		}
		
		public function obterComGravacao($gravacao){
			$comando = "
			SELECT t.nome,t.sprite,tg.idMapa,tg.x,tg.y,tg.looking,tg.pokemonDollar,tg.id 
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
		
		public function mover($x,$y,$looking){
			//$comando = "select * from mapa_pixel where x=:x and y=:y and possivelCaminhar = 1";
			//$parametros = array(
			//	'x' => $x,
			//	'y' => $y
			//);
			//$mapaPixel = $this->getBancoDados()->consultar($comando,$parametros);
			
			//if(!count($mapaPixel))
			//	Throw new Exception('Não foi possível mover');
			
			$this->atualizarPosicao($x,$y,$looking);
			
			return true;
		}
		
		public function atualizarPosicao($x,$y, $looking){
			$comando = "update treinador_gravacao set x = :x, y = :y, looking = :looking where id = :vezIdTreinador";
			$parametros = array(
				'vezIdTreinador' => $_SESSION['vezIdTreinador'],
				'x' => $x,
				'y' => $y,
				'looking' => $looking
			);
			$this->getBancoDados()->executar($comando,$parametros);
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
		
		public function obterTreinadorDaVez(){
			$comando = 'select tg.id,treinador.nome,treinador.sprite,tg.idMapa,tg.x,tg.y,tg.pokemonDollar from treinador 
			join treinador_gravacao tg on tg.idTreinador = treinador.id and tg.idGravacao = :idGravacao and treinador.id = :id';
			$parametros = array(
				'id' => $_SESSION['vezIdTreinador'],
				'idGravacao' => $_SESSION['gravacao']
			);
			return $this->getBancoDados()->obterObjeto($comando, array($this, 'transformarEmObjeto'), $parametros, true);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('treinador', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('treinador', $id);
		}
	}
?>