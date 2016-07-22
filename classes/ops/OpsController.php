<?php
	class OpsController{
		private $servico = null;
		
		public function __construct(){
			$bancoDados = BDSingleton::get();
			$opsDAO = new OpsDAO($bancoDados);
			$this->servico = new OpsService($opsDAO);
		}
		
		public function criarOps($exception){
			$ops = new Ops();
			$ops->setArquivo($exception['arquivo']);
			$ops->setTrace($exception['trace']);
			$ops->setMensagem($exception['mensagem']);
			return $ops;
		}

		public function gerenciar(){
			global $ops;
			global $_;
	
			if(isset($_GET['action2']) && $_GET['action2'] == "excluir"){
				try{
					if($this->excluirComId($_GET['id'])) {
						echo "<div class='alert alert-success'>Log de excessão excluido com sucess</div>";
					} else {
						echo "<div class='alert alert-error'>Não foi possivel excluir o log de excessão</div>";
					}
				}catch(Exception $e){
					require_once($_->raiz."/classes/CriaOErro.php");
				}
			}

			try{
				$ops = $this->todosOsOps();
			}catch(Exception $e){
				require_once($_->raiz."/classes/CriaOErro.php");
			}
		}
		
		public function salvar($ops){
			return $this->servico->salvar($ops);
		}
		
		public function opsComId($id){
			return $this->servico->opsComId($id);
		}
		
		public function todosOsOps(){
			return $this->servico->todosOsOps();
		}
		
		public function excluirComId($id){
			return $this->servico->excluirComId($id);
		}
	}
?>