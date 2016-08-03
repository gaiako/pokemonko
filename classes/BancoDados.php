<?php

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once($_->raiz."/util/autoload.php");
require_once($_->raiz."/util/Util.php");

/**
 * Database utilities.
 *
 * @author Douglas Cardinot <douglasccardinot@gmail.com>
 * @author Cássio Amorim <cassioamartins07@gmail.com>
 * version	1.1
 * 		Acrescentado funcionalidade de opção em ser completo
 * @version 1.2
 *		Acrescentado funcionalidade para obter o último id inserido
 */

class BancoDados{

	private $pdo = NULL;	//PDO Object - Carrega a conexão com o banco de dados

	public function obterUltimoIdInserido(){
		return $this->pdo->lastInsertId();
	}

	public function obterUltimoId(){
		return $this->obterUltimoIdInserido();
	}

	public function ultimoId(){
		return $this->obterUltimoIdInserido();
	}
	
	/**
	 * @const ID_INEXISTENTE 0
	 *	Constante referente ao id considerado inexistente pelo banco de dados
	 */
	const ID_INEXISTENTE = 0;
	
	/**
	 * Construtor - Cria a classe banco dados já abrindo a conexão com o banco
	 *
	 * @example new BancoDados();
	 * @return void
	 */
	public function __construct() {
		global $_;

		$dsn = "mysql:dbname=pokemon;host=localhost";
		$usuario = "root";
		$senha = "";

		try {
			$this->pdo = new PDO($dsn, $usuario, $senha);
		} catch (PDOException $e) {
			echo 'Instalando base de dados... Isso pode demorar um pouco.';
			// Name of the file
			$filename = $_SERVER['DOCUMENT_ROOT'].'/doc/sql/pokemon.sql';
			// MySQL host
			$mysql_host = 'localhost';
			// MySQL username
			$mysql_username = 'root';
			// MySQL password
			$mysql_password = '';
			// Database name
			$mysql_database = 'test';

			// Connect to MySQL server
			mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
			// Select database
			mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file($filename);
			// Loop through each line
			foreach ($lines as $line)
			{
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;

			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
				// Perform the query
				mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
				// Reset temp variable to empty
				$templine = '';
			}
			}
			header('Location: /');
		}
	}
	
	/**
	 * Inicia uma transação no banco de dados
	 * 
	 * @author Douglas
	 *
	 * @name iniciarTransacao
	 * @example iniciarTransacao();
	 * @return void
	 */
	public function iniciarTransacao(){ //throws
		$this->pdo->beginTransaction();
	}
	
	/**
	 * Conclui uma transação aberta no o banco de dados
	 * 
	 * @author Douglas
	 *
	 * @name concluirTransacao or finalizarTransacao
	 * @example concluirTransacao(); or finalizarTransacao();
	 * @return void
	 */
	public function concluirTransacao(){ //throws
		$this->pdo->commit();
	}
	
	public function finalizarTransacao(){ //throws
		$this->pdo->commit();
	}
	
	/**
	 * Desfaz uma transação aberta no o banco de dados
	 * 
	 * @author Douglas
	 *
	 * @name desfazerTransacao
	 * @example desfazerTransacao();
	 * @return void
	 */
	public function desfazerTransacao(){ //throws
		$this->pdo->rollBack();
	}
	
	/**
	 * Verifica se uma transação está aberta no momento
	 * Esta função funciona apenas no PHP5 >= 5.3.3
	 * 
	 * @author Douglas
	 *
	 * @name emTransacao
	 * @example emTransacao();
	 * @return bool emTransacao
	 */
	public function emTransacao(){
		return PDO::inTransaction();
	}
	
	/**
	 * Retorna o id do próximo dado que será salvo no banco de dados
	 * 
	 * @author Douglas
	 *
	 * @name gerarId
	 * @example gerarId("produto");
	 * @param string tabela
	 *	A tabela para verificar o id do próximo registro a ser salvo
	 * @return int id
	 */
	public function gerarId($tabela){ //throws
		$comando = "select id from $tabela order by id desc limit 1";
		$preparado = $this->rodar($comando);
		if($preparado->rowCount()<=0)
			return 1;
		$vetor = $preparado->fetchAll();
		return $vetor[ 0 ]['id']+1;
	}
	
	/**
	 * Verifica se um dado já está registrado na tabela
	 * 
	 * @author Douglas
	 *
	 * @name existe
	 * @example existe("produto", "nome", "Suco de uva", 4, true);
	 * @param string tabela
	 *	A tabela para verificar a existência do registro
	 * @param string campo
	 *	O campo utilizado para verificação
	 * @param string informacao
	 *	A informação chave para a verificação
	 * @param int id 
	 *	A tabela para verificar a existência do registro (default to 0)
	 * @param bool verificaAtivo 
	 *	Controle de verificação da coluna de controle de exclusão de registro (default to true)
	 * @return bool
	 */
	public function existe($tabela, $campo, $informacao, $id = 0, $verificaAtivo = true){ //throws
		$comando = "select $campo from $tabela where $campo = :informacao and id != :id";
		if($verificaAtivo)
			$comando .= " and ativo = 1";
		$parametros = array(
			'informacao' => $informacao,
			'id' => $id 
		);
		$preparado = $this->rodar($comando, $parametros);
		if($preparado->rowCount() > 0)
			return true;
		return false;
	}
	
	/**
	 * Executa uma consulta no banco e retorna um array com os dados encontrados
	 * 
	 * @author Douglas
	 *
	 * @name consultar
	 * @example consultar("select * from produto where valor < :valor", array("valor" => 50.0));
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @return array 
	 */
	public function consultar($comando, $parametros = array(), $uniqueAssociation = false){ //throws
		$preparado = $this->rodar($comando, $parametros);
		if($uniqueAssociation){
			return $preparado->fetchAll(PDO::FETCH_ASSOC);
		}
		return $preparado->fetchAll();
	}
	
	/**
	 * Executa uma query no banco.
	 * 
	 * @author Douglas
	 *
	 * @name executar
	 * @example executar("insert into produto(nome) values (:nome)", array("nome" => "Suco de uva"));
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @return int
	 *	Número de linhas afetadas
	 */
	public function executar($comando, $parametros = array()){ //throws
		$preparado = $this->rodar($comando, $parametros);
		return $preparado->rowCount();
	}
	
	/**
	 * Remove, por completo, um registro da tabela pelo seu id
	 * 
	 * @author Douglas
	 *
	 * @name excluir
	 * @example excluir("produto", 5);
	 * @param string tabela
	 *	Tabela do banco onde será realizada a exclusão
	 * @param int id
	 *	Id do registro a ser excluído
	 * @return int
	 *	Número de linhas afetadas
	 */
	public function excluir($tabela, $id){ //throws
		$comando = "delete from $tabela where id = :id";
		$parametros = array(
			'id' => $id );
		$preparado = $this->rodar($comando, $parametros);
		return $preparado->rowCount();
	}
	
	/**
	 * Desativa um registro da tabela, setando o campo "ativo" como 0 (zero)
	 * 
	 * @author Douglas
	 *
	 * @name desativar
	 * @example desativar("produto", 5);
	 * @param string tabela
	 *	Tabela do banco onde será realizada a desativação
	 * @param int id
	 *	Id do registro a ser desativado
	 * @return int
	 *	Número de linhas afetadas
	 */
	public function desativar($tabela, $id){ //throws
		$comando = "update $tabela set ativo = 0 where id = :id";
		$parametros = array(
			'id' => $id );
		$preparado = $this->rodar($comando, $parametros);
		return $preparado->rowCount();
	}
	
	/**
	 * Executa uma consulta e usa o callback para formar os objetos do tipo desejado
	 * 
	 * @author Douglas
	 *
	 * @name obterObjetos
	 * @example obterObjetos("select * from produto", array('ProdutoDAO', 'transformarEmObjeto'), array(), "nome", 20, 0);
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array callback
	 *	Callback para a transformação de registros em objetos
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @param string orderBy
	 *	Campo para ordenação dos registros encontrados (default to 'id')
	 * @param string limit
	 *	Quantidade máxima de registros a serem considerados (default to null)
	 * @param string offset
	 *	Contagem dos registros a partir deste índice (default to 0)
	 * @param string completo
	 *	Envia para a transfomação a intenção de obter ou não o objeto completo (default to true)
	 * @return array unknown_type
	 *	Array de objetos - o tipo do objeto é definido pelo callback enviado
	 */
	public function obterObjetos($comando, $callback, $parametros = array(), $orderBy = 'id', $limit = null, $offset = 0, $completo = true){
		if($orderBy != '')
			$comando .= " order by $orderBy";
		if(isset($limit))
			$comando .= " limit $offset, $limit";
		$linhas = $this->consultar($comando, $parametros);
		$objetos = array();
		foreach($linhas as $l){
			$obj = call_user_func_array($callback, array($l, $completo));
			array_push($objetos, $obj);
		}
		return $objetos;
	}
	
	/**
	 * Executa uma consulta e usa o callback para formar o objeto do tipo desejado
	 * 
	 * @author Douglas
	 *
	 * @name obterObjeto
	 * @example obterObjeto("select * from produto where id = :id", array('ProdutoDAO', 'transformarEmObjeto'), array("id" => 5));
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array callback
	 *	Callback para a transformação de registros em objetos
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @param string completo
	 *	Envia para a transfomação a intenção de obter ou não o objeto completo (default to true)
	 * @return unknown_type
	 *	Objeto do que é definido pelo callback enviado
	 */
	public function obterObjeto($comando, $callback, $parametros = array(), $completo = true){
		$objetos = $this->obterObjetos($comando, $callback, $parametros, '', null, 0, $completo);
		if(count($objetos) < 1){
			return null;
			//throw new NaoEncontradoException("Não foi possível localizar o registro em nosso banco de dados");
		}
		return $objetos[0];
	}
	
	/**
	 * Gera um teste para ser feito no MySQL com a consulta e os parâmetros desejados
	 * 
	 * @author Douglas
	 *
	 * @name geraTeste
	 * @example geraTeste("insert into produto(nome) values (:nome)", array("nome" => "Suco de uva"));
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @return String
	 *	Teste para rodar no MySQL
	 */
	 public function geraTeste($comando, $parametros = array()){
		foreach($parametros as $key => $p){
			$dado = $p;
			$type = gettype( $p );
			switch ( $type ) {
				case 'string' : 
					if(!is_numeric($dado))
						$dado = '"' . addslashes( str_replace("\n", "\\n", str_replace("\r\n", "\\n", $dado)) ) . '"';
					break;
				case 'boolean' : // continue
					$dado = ($dado == true) ? "1" : "0";
					break;
				case 'number' : // continue
				case 'integer' : // continue
				case 'float' : // continue
				case 'double' : // continue
				case 'NULL' : 
					break;
				default :
					die("Tipo de dado impróprio para comando SQL: '".$key."' => ".$type);
			}
			$comando = str_replace(":".$key.",", $dado.",", $comando);
			$comando = str_replace(":".$key." ", $dado." ", $comando);
			$comando = str_replace(":".$key.")", $dado.")", $comando);
			$comando = str_replace(":".$key."%", $dado."%", $comando);
		}
		return $comando;
	 }
	
	/**
	 * Executa o comando preparado
	 * 
	 * @author Douglas
	 *
	 * @name rodar
	 * @example rodar("insert into produto(nome) values (:nome)", array("nome" => "Suco de uva"));
	 * @param string comando
	 *	Comando SQL para a consulta
	 * @param array parametros 
	 *	Matriz de valores com a mesma quantidade de parâmetros vinculados na instrução SQL (default to array())
	 * @return PDOStatement
	 *	O SQL preparado
	 */
	private function rodar($comando, $parametros = array()){ //throw
		$preparado = $this->pdo->prepare($comando);
		if(!$preparado->execute($parametros))
			throw new DBException("Houve um erro no comando: <br />".$comando."<br />Parâmetros:<br />".Util::arrayParaTexto($parametros)."<br />ERROR: (".implode(" - ", $this->pdo->errorInfo()).")<br /><br />Testador MySQL:<br />".$this->geraTeste($comando, $parametros));
		return $preparado;
	}
}
?>
