<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	require_once($_->raiz."/util/autoload.php");
	
	class OpsDAO{
		private $bancoDados = null;
		
		public function __construct($bancoDados){
			$this->bancoDados = $bancoDados;
		}
		
		public function salvar($ops){
			$id = $this->bancoDados->gerarId("ops");
			$comando = "insert into ops (id, arquivo, trace, mensagem, horario) values (:id, :arquivo, :trace, :mensagem, now())";
			$parametros = array(
				"id" => $id,
				"arquivo" => $ops->getArquivo(),
				"trace" => $ops->getTrace(),
				"mensagem" => $ops->getMensagem() 
			);
			$this->bancoDados->executar($comando, $parametros);
			return $id;
		}
		
		private function transformarEmOps($l){
			$ops = new Ops();
			$ops->setId($l['id']);
			$ops->setArquivo($l['arquivo']);
			$ops->setTrace($l['trace']);
			$ops->setMensagem($l['mensagem']);
			$ops->setHorario($l['horario']);
			return $ops;
		}
		
		public function opsComId($id){
			$comando = "select * from ops where ativo = 1 and id = :id";
			$parametros = array(
				"id" => $id 
			);
			$linhas = $this->bancoDados->consultar($comando, $parametros);
			if(count($linhas) <= 0)
				throw new DAOException("Ops não encontrado");
			return $this->transformarEmOps($linhas[0]);
		}
		
		public function todosOsOps(){
			$comando = "select * from ops where ativo = 1 order by horario desc";
			$linhas = $this->bancoDados->consultar($comando);
			$ops = array();
			foreach($linhas as $l){
				array_push($ops, $this->transformarEmOps($l));
			}
			return $ops;
		}
		
		public function excluirComId($id){
			return $this->bancoDados->excluir("ops", $id);
		}
	}
?>