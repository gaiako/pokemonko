<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_->raiz.'/classes/BancoDados.php');
	
	abstract class DAO{
		private $bancoDados = null;
		
		public function __construct($bancoDados){
			$this->bancoDados = $bancoDados;
		}
		
		protected function getBancoDados(){
			return $this->bancoDados;
		}
		
		public function salvar($obj){
			try{
				$this->getBancoDados()->iniciarTransacao();
				$return = null;

				if($obj->getId() == BancoDados::ID_INEXISTENTE){
					$className = $this->className($obj);
					//$id = $this->getBancoDados()->gerarId($className);
					//$obj->setId($id);
					$return = $this->adicionarNovo($obj);
				}else{
					$return = $this->atualizar($obj);
				}

				$this->getBancoDados()->finalizarTransacao();
				return $return;
			}catch(Exception $e){
				$this->getBancoDados()->desfazerTransacao();
				throw $e;
			}
			return false;
		}
		
		private function className($obj){
			$objTested = (is_object($obj)) ? get_class($obj) : $obj;
			if(get_parent_class($objTested))
				return $this->className(get_parent_class($obj));
			return strtolower($objTested);
		}
		
		abstract protected function adicionarNovo($obj);
		abstract protected function atualizar($obj);
		abstract protected function parametros($obj);
		abstract public function existe($obj);
		abstract public function transformarEmObjeto($registro);
		abstract public function obterTodos($orderBy = 'id', $limit = null, $offset = 0, $completo = true);
		abstract public function obterComId($id, $completo = true);
		
		public function obterComIds($ids, $completo = true){
			$objetos = array();
			try{
				foreach($ids as $id)
					array_push($objetos, $this->obterComId($id, $completo));
			}catch(Exception $e){
				require_once($_->raiz."/classes/CriaOErro.php");
			}
			return $objetos;
		}
		
		abstract public function desativarComId($id);
		abstract public function excluirComId($id);
	}
?>