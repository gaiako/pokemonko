<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	require_once($_->raiz."/util/autoload.php");
	require_once($_->raiz."/classes/singleton/FactorySingleton.php");
	
	abstract class Controller{
		protected $classe = '';
		private $service = null;
		
		protected function getService(){
			return $this->service;
		}
		
		protected function setService($service){
			$this->service = $service;
		}
		
		protected function getServiceFactory(){
			$DAOFactory = FactorySingleton::getDefaultDAOFactory();
			$serviceFactory = FactorySingleton::getDefaultServiceFactory($DAOFactory);
			return $serviceFactory;
		}
		
		protected function povoarSimples($obj, $campos, $request){
			$reflectionObject = new ReflectionObject($obj);
			foreach($campos as $c){
				$reflectionObject->getMethod("set".ucfirst($c))->invoke($obj, $request[$c]);
			}
		}
		
		protected function verificaEnvio($campos, $request){
			foreach($campos as $c){
				if(!isset($request[$c]))
					throw new ControllerException("Campo $c não foi enviado");
			}
		}
		
		public function salvar($obj, &$erro){
			return Util::makeService($this->classe)->salvar($obj, $erro);
		}

		private function getMap(){
			global $_;
			$url = $_->raiz."/classes/_map.json";
		    $json = file_get_contents($url);
		    $_map = json_decode($json, TRUE);
		    if(function_exists("json_last_error") && json_last_error() != JSON_ERROR_NONE){
				throw new LogicException("O JSON _map contém um erro");
			}
			$className = get_class($this);
			$className = str_replace("Controller", "", $className);
			return $_map[$className];
		}

		protected function setGlobals($objs){
			$map = $this->getMap();
			if(!is_array($map) || $map['plural'] == null){
				return false;
			}
			global ${$map['plural']};
			${$map['plural']} = $objs;
			global $render;
			$render[$map['plural']] = array();
			array_push($render[$map['plural']],$objs);
		}

		protected function setGlobal($obj){
			$map = $this->getMap();
			if(!is_array($map) || $map['singular'] == null){
				return false;
			}
			global ${$map['singular']};
			${$map['singular']} = $objs;
			global $render;
			$render[$map['singular']] = array();
			array_push($render[$map['singular']],$obj);
		}
		
		public function obterTodos($orderBy = '', $limit = null, $offset = 0, $completo = true, $setGlobal = true){
			$objs = Util::makeService($this->classe)->obterTodos($orderBy, $limit, $offset, $completo);
			if($setGlobal) $this->setGlobals($objs);
			return $objs;
		}
		
		public function obterComId($id, $completo = true, $setGlobal = true){
			$obj = Util::makeService($this->classe)->obterComId($id, $completo);
			if($setGlobal) $this->setGlobal($obj);
			return $obj;
		}
		
		public function obterComIds($ids, $completo = true, $setGlobal = true){
			$objs = Util::makeService($this->classe)->obterComIds($ids, $completo);
			if($setGlobal) $this->setGlobals($objs);
			return $objs;
		}
		
		public function desativarComId($id){
			return Util::makeService($this->classe)->desativarComId($id);
		}
		
		public function excluirComId($id){
			return Util::makeService($this->classe)->excluirComId($id);
		}

		public function excluir(){
			try{
				Util::makeService($this->classe)->desativarComId($_GET['id']);
			}catch(Exception $e){
				require_once($_->raiz."/classes/CriaOErro.php");
			}
		}
	}
?>