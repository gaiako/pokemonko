<?php
	class OpsService{
		private $opsDAO = null;
		
		public function __construct($opsDAO){
			$this->opsDAO = $opsDAO;
		}
		
		public function salvar($ops){
			return $this->opsDAO->salvar($ops);
		}
		
		public function opsComId($id){
			return $this->opsDAO->opsComId($id);
		}
		
		public function todosOsOps(){
			return $this->opsDAO->todosOsOps();
		}
		
		public function excluirComId($id){
			return $this->opsDAO->excluirComId($id);
		}
	}
?>