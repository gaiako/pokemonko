<?php
	abstract class Service{
		private $dao = null;
		
		public function __construct($dao){
			$this->dao = $dao;
		}
		
		protected function getDao(){
			return $this->dao;
		}
		
		public function salvar($obj, &$erro){
			$this->protegeBanco($obj);
			$this->validar($obj, $erro);
			//Pre-modificações que devem ser tomadas antes de salvar o objeto
			$this->preSalvar($obj);
			return $this->getDao()->salvar($obj);
		}
		
		abstract protected function validar($obj, &$erro);
		
		protected function protegeBanco($obj){
			if(is_array($obj))
				$objs = $obj;
			else $objs = array($obj);
			foreach($objs as $obj){
				$reflectionObject = new ReflectionObject($obj);
				foreach($reflectionObject->getProperties(ReflectionProperty::IS_PRIVATE) as $atributo){
					if($reflectionObject->hasMethod("get".ucfirst($atributo->getName()))){
						$campo = $reflectionObject->getMethod("get".ucfirst($atributo->getName()))->invoke($obj);
						if(is_string($campo)){
							$campo = trim(str_replace("<br />", "", $campo));
							if($reflectionObject->hasMethod("set".ucfirst($atributo->getName()))){
								$reflectionObject->getMethod("set".ucfirst($atributo->getName()))->invoke($obj, $campo);
							}
						}
					}
				}
			}
		}
		
		protected function posObter(&$obj) { return true; }
		protected function preSalvar(&$obj) { return true; }
		protected function posExcluir($id) { return true; }
		
		public function obterTodos($orderBy = '', $limit = null, $offset = 0, $completo = true){
			$objs = $this->getDao()->obterTodos($orderBy, $limit, $offset, $completo);
			$this->posObter($objs);
			return $objs;
		}
		
		public function obterComId($id, $completo = true){
			$obj = $this->getDao()->obterComId($id, $completo);
			$this->posObter($obj);
			return $obj;
		}
		
		public function obterComIds($ids, $completo = true){
			$objs = $this->getDao()->obterComIds($ids, $completo);
			$this->posObter($objs);
			return $objs;
		}
		
		public function desativarComId($id){
			$status = $this->getDao()->desativarComId($id);
			if($status) {
				$status =  $status && $this->posExcluir($id);
			}
			return $status;
		}
		
		public function excluirComId($id){
			$status = $this->getDao()->excluirComId($id);
			if($status) {
				$status =  $status && $this->posExcluir($id);
			}
			return $status;
		}
	}
?>