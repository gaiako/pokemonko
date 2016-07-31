<?php
	class MapaDAO extends DAO{

		public function __construct($bancoDados){
			parent::__construct($bancoDados);
		}

		protected function adicionarNovo($mapa){
			$comando = 'insert into mapa (id, nome, dimensaoX, dimensaoY, xInicial, yInicial, maxPokemons, intervaloCriacao, intervaloMovimento) values (:id, :nome, :dimensaoX, :dimensaoY, :xInicial, :yInicial, :maxPokemons, :intervaloCriacao, :intervaloMovimento)';
			$this->getBancoDados()->executar($comando, $this->parametros($mapa));
			$id = $this->getBancoDados()->ultimoId();
			$mapa->setId($id);
			
			$this->gerarMapaPixels($mapa);
		}

		protected function atualizar($mapa){
			$comando = 'update mapa set nome = :nome, dimensaoX = :dimensaoX, dimensaoY = :dimensaoY, xInicial = :xInicial, yInicial = :yInicial, maxPokemons = :maxPokemons, intervaloCriacao = :intervaloCriacao, intervaloMovimento = :intervaloMovimento where id = :id';
			$this->getBancoDados()->executar($comando, $this->parametros($mapa,true));
		}

		protected function parametros($mapa,$update = false){
			$parametros = array(
				'id' => $mapa->getId(),
				'nome' => $mapa->getNome(),
				'dimensaoX' => $mapa->getDimensaoX(),
				'dimensaoY' => $mapa->getDimensaoY(),
				'xInicial' => $mapa->getXInicial(),
				'yInicial' => $mapa->getYInicial(),
				'maxPokemons' => $mapa->getMaxPokemons(),
				'intervaloCriacao' => $mapa->getIntervaloCriacao(),
				'intervaloMovimento' => $mapa->getIntervaloMovimento()
			);
			if($update)
				$parametros['id'] = $mapa->getId();
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
			$mapa->setXInicial($l['xInicial']);
			$mapa->setYInicial($l['yInicial']);
			$mapa->setMaxPokemons($l['maxPokemons']);
			$mapa->setIntervaloCriacao($l['intervaloCriacao']);
			$mapa->setIntervaloMovimento($l['intervaloMovimento']);
			return $mapa;
		}
		
		public function gerarMapaPixels($mapa){
			$dimensaoX = $mapa->getDimensaoX();
			$dimensaoY = $mapa->getDimensaoY();
			
			for($y=1;$y<=$dimensaoY;$y++){
				$dificuldade = ceil($y/10);
				for($x=1;$x<=$dimensaoX;$x++){
					$comando = "insert into mapa_pixel (idMapa,x,y,dificuldade) values (:idMapa,:x,:y,:dificuldade)";
					$parametros = array(
						'idMapa' => $mapa->getId(),
						'x' => $x,
						'y' => $y,
						'dificuldade' => $dificuldade
					);
					$this->getBancoDados()->executar($comando,$parametros);
				}
			}
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
		
		public function obterTodosOsPixels($mapa){
			$comando = "
			select * 
			from mapa_pixel  
			where idMapa = :idMapa";
			$parametros = array(
				'idMapa' => $mapa->getId()
			);
			return $this->getBancoDados()->consultar($comando,$parametros);
		}
		
		public function obterMapaPixelComRestricoes($restricoes, $orderBy = 'rand()', $limit = null){
			$select = 'select * from mapa_pixel ';
			$join = '';
			$where = ' where ativo = 1 and possivelCaminhar = 1 ';
			$parametros = array();
			
			if(isset($restricoes['idMapa'])){
				$where .= ' and idMapa = :idMapa';
				$parametros['idMapa'] = $restricoes['idMapa'];
			}
			
			if(isset($restricoes['idGrupo'])){
				$where .= ' and idGrupo = :idGrupo ';
				$parametros['idGrupo'] = $restricoes['idGrupo'];
			}else{
				$where .= ' and idGrupo is not null ';
			}
			
			$orderBy = 'order by '.$orderBy;
			if(strlen($limit) > 0)
				$limit = ' limit '.$limit;
			
			$comando = $select.$join.$where.$orderBy.$limit;
			$l = $this->getBancoDados()->consultar($comando,$parametros);
			return $l[0];
		}
		
		public function obterMapaPixelComId($idMapaPixel){
			$comando = "
			select mp.* 
			from mapa_pixel mp 
			where mp.id = :id
			";
			$parametros['id'] = $idMapaPixel;
			return $this->getBancoDados()->consultar($comando,$parametros);
		}

		public function desativarComId($id){
			$this->getBancoDados()->desativar('mapa', $id);
		}

		public function excluirComId($id){
			$this->getBancoDados()->excluir('mapa', $id);
		}
		
		public function updateMapaPixel($idMapaPixel,$terreno,$objeto,$idAcao,$bloqueado){
			$comando = "update mapa_pixel set ativo = 1";
			$parametros['id'] = $idMapaPixel;
			if(strlen($terreno)){
				$comando .= ',terreno = :terreno';
				$parametros['terreno'] = $terreno;
			}
			if(!strlen($objeto))
				$objeto = null;
			if($objeto !== 0){
				$comando .= ',objeto = :objeto';
				$parametros['objeto'] = $objeto;
			}
			
			if(!is_numeric($idAcao))
				$idAcao = null;
			$comando .= ',idAcao = :idAcao';
			$parametros['idAcao'] = $idAcao;
			
			if(!is_numeric($bloqueado))
				$bloqueado = null;
			$comando .= ',bloqueado = :bloqueado';
			$parametros['bloqueado'] = $bloqueado;
			
			$comando .= ' where id = :id';
			$this->getBancoDados()->executar($comando,$parametros);
			$mapaPixel = $this->obterMapaPixelComId($idMapaPixel);
			
			$style = '';
			$objeto = '';
			
			if($mapaPixel[0]['terreno'] != '')
				$style = 'background-image: url("'.'/app/assets/images/terreno/'.$mapaPixel[0]['terreno'].'")';
			if($mapaPixel[0]['objeto'] != '')
				$objeto = '<img style="z-index: 1000" src="'.'/app/assets/images/objeto/'.$mapaPixel[0]['objeto'].'" />';
			
			return array(
				'style' => $style,
				'objeto' => $objeto
			);
		}
		
		public function setPossivelCaminhar($idMapa,$possivelCaminhar,$x,$y){
			$comando = "update mapa_pixel set possivelCaminhar = :possivelCaminhar 
			where x >= :x1 and x <= :x2 and y >= :y1 and y <= :y2 and idMapa = :idMapa";
			$parametros = array(
				'idMapa' => $idMapa,				'possivelCaminhar' => $possivelCaminhar,
				'x1' => $x['1'],
				'x2' => $x['2'],
				'y1' => $y['1'],
				'y2' => $y['2']
			);
			return $this->getBancoDados()->executar($comando,$parametros);
		}
		
		public function setIdGrupo($idMapa,$idGrupo,$x,$y){
			$comando = "update mapa_pixel set idGrupo = :idGrupo 
			where x >= :x1 and x <= :x2 and y >= :y1 and y <= :y2 and idMapa = :idMapa";
			$parametros = array(
				'idMapa' => $idMapa,
				'idGrupo' => $idGrupo,
				'x1' => $x['1'],
				'x2' => $x['2'],
				'y1' => $y['1'],
				'y2' => $y['2']
			);
			return $this->getBancoDados()->executar($comando,$parametros);
		}
		
		public function criarPokemonAleatoriamente($restricoes){
			$mapaPixel = $this->obterMapaPixelComRestricoes($restricoes);
			$mapa = $this->obterComId($mapaPixel['idMapa']);
			
			$restricoes = array(
				'idGrupo' => $mapaPixel['idGrupo']
			);
			
			$pokemonBase = Util::makeDao('pokemonBase')->obterComRestricoes($restricoes,'rand()',1,0,true);
			$pokemonBase = $pokemonBase[0];
			
			$pokemon = Util::makeController('pokemon')->criarAPartirDeBase($pokemonBase,$mapaPixel);
			
			//Verificar se vai excluir
			$pokemonExcluir = Util::makeController('pokemon')->obterComRestricoes(array('idMapa' => $mapa->getId()));
			$totalExcluir = count($pokemonExcluir)-$mapa->getMaxPokemons();
			$excluidos = array();
			if($totalExcluir > 0){
				foreach($pokemonExcluir as $p){
					if($totalExcluir <= 0)
						break;
					$comando = "delete from pokemon where id = ".$p->getId();
					$this->getBancoDados()->executar($comando,$parametros);
					array_push($excluidos,$p->getId());
					$totalExcluir--;
				}
			}
			
			$del = null;
			if(count($excluidos))
				$del = $excluidos;
			
			return array(
				'add' => $pokemon,
				'del' => $del
			);
		}
	}
?>