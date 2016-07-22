<?php
/**
* Function Utilities.
*
* @author
*	Cássio Martins <cassioamartins07@gmail.com>
*	Douglas Cardinot <douglas_cardinot@ig.com.br>
*	Igor Frotté Pedro <igorfrotte@hotmail.com>
*   JoséEduardo de Almeida <dudu2904@hotmail.com>
* @version	1.6.2
*/
abstract class Util {

	public static function makeController($class){
		global $_controller;
		$class = ucfirst($class);
		$className = $class.'Controller';
		if(!isset($_controller[$class]))
			$_controller[$class] = new $className();
		return $_controller[$class];
	}

	public static function makeService($class){
		global $_service;
		$class = ucfirst($class);
		$className = $class.'Service';
		if(!isset($_service[$class]))
			$_service[$class] = new $className(self::makeDAO($class));
		return $_service[$class];
	}

	public static function makeDAO($class){
		global $_dao;
		$class = ucfirst($class);
		$className = $class.'DAO';
		if(!isset($_dao[$class]))
			$_dao[$class] = new $className(BDSingleton::get());
		return $_dao[$class];
	}
	
	/**
	* Remove os caracteres especiais de um texto
	* 
	* @author Douglas
	*
	* @name removerCaracteresEspeciais
	* @example removerCaracteresEspeciais("Atenção");
	* @param string texto
	*	O texto para ser removido os caracteres
	* @return string texto
	*/
	public static function removerCaracteresEspeciais($texto){
		$texto = str_replace("á", "a", $texto);
		$texto = str_replace("Á", "a", $texto);
		$texto = str_replace("à", "a", $texto);
		$texto = str_replace("À", "A", $texto);
		$texto = str_replace("â", "a", $texto);
		$texto = str_replace("Â", "A", $texto);
		$texto = str_replace("ã", "a", $texto);
		$texto = str_replace("Ã", "A", $texto);
		$texto = str_replace("ä", "a", $texto);
		$texto = str_replace("Ä", "A", $texto);

		$texto = str_replace("é", "e", $texto);
		$texto = str_replace("É", "E", $texto);
		$texto = str_replace("è", "e", $texto);
		$texto = str_replace("È", "E", $texto);
		$texto = str_replace("ê", "e", $texto);
		$texto = str_replace("Ê", "E", $texto);
		$texto = str_replace("ë", "e", $texto);
		$texto = str_replace("Ë", "E", $texto);

		$texto = str_replace("í", "i", $texto);
		$texto = str_replace("Í", "I", $texto);
		$texto = str_replace("Ì", "I", $texto);
		$texto = str_replace("ì", "i", $texto);
		$texto = str_replace("Î", "I", $texto);
		$texto = str_replace("î", "i", $texto);
		$texto = str_replace("ï", "i", $texto);
		$texto = str_replace("Ï", "i", $texto);

		$texto = str_replace("ó", "o", $texto);
		$texto = str_replace("Ó", "O", $texto);
		$texto = str_replace("ò", "o", $texto);
		$texto = str_replace("Ò", "O", $texto);
		$texto = str_replace("õ", "o", $texto);
		$texto = str_replace("Õ", "O", $texto);
		$texto = str_replace("ô", "o", $texto);
		$texto = str_replace("Ô", "O", $texto);
		$texto = str_replace("ö", "o", $texto);
		$texto = str_replace("Ö", "O", $texto);

		$texto = str_replace("ú", "u", $texto);
		$texto = str_replace("Ú", "U", $texto);
		$texto = str_replace("ù", "u", $texto);
		$texto = str_replace("Ù", "U", $texto);
		$texto = str_replace("ü", "u", $texto);
		$texto = str_replace("Ü", "U", $texto);
		
		$texto = str_replace("ç", "c", $texto);
		$texto = str_replace("Ç", "C", $texto);
		$texto = str_replace('º','o',$texto);
		$texto = str_replace('à','a',$texto);
		$texto = str_replace("°","o",$texto);
		$texto = str_replace("ñ","n",$texto);
		$texto = str_replace("Ñ","N",$texto);
		return $texto;
	}
	
	/**
	* Remove as pontuações de um texto
	* 
	* @author Sergio
	*1 º passo - VEJA QUE PRIMEIRO EU VOU GERAR UM SALT JÁ ENCRIPTADO EM MD5
	*2 º passo -PRIMEIRA ENCRIPTAÇÃO ENCRIPTANDO COM crypt
	*3 º passo - SEGUNDA ENCRIPTAÇÃO COM sha512 (128 bits)
	*4 º passo - AGORA RETORNO O VALOR FINAL ENCRIPTADO
	* @name removerPontuacoes
	* @example encripta(senhaDoUsuario);
	* @param string senha
	* @return string senha encriptada
	*/
	public static function encripta($senha){
		$senha = sha1($senha);
		$salt = md5("<:rm44E5=:oYi<x>02?mJ6R>i}<E:");
		$codifica = crypt($senha,$salt);
		$codifica = hash('sha512',$codifica);
		return $codifica;
	}

	/**
	* Remove as pontuações de um texto
	* 
	* @author Douglas
	*
	* @name removerPontuacoes
	* @example removerCaracteresEspeciais("Olá! 100% de aproveitamento...");
	* @param string texto
	*	O texto para ser removido as pontuações
	* @return string texto
	*/
	public static function removerPontuacoes($texto){
		$texto = str_replace("%","",$texto);
		$texto = str_replace("$","",$texto);
		$texto = str_replace("&","e",$texto);
		$texto = str_replace("#","",$texto);
		$texto = str_replace("\/","-",$texto);
		$texto = str_replace("\\","-",$texto);
		$texto = str_replace("@","",$texto);
		$texto = str_replace("*","",$texto);
		$texto = str_replace("\"","",$texto);
		$texto = str_replace("\'","",$texto);
		$texto = str_replace("{","",$texto);
		$texto = str_replace("}","",$texto);
		$texto = str_replace("[","",$texto);
		$texto = str_replace("]","",$texto);
		$texto = str_replace(":","",$texto);
		$texto = str_replace(";","",$texto);
		$texto = str_replace(">","",$texto);
		$texto = str_replace("<","",$texto);
		$texto = str_replace(",","",$texto);
		$texto = str_replace("?","",$texto);
		$texto = str_replace("|","",$texto);
		$texto = str_replace("!","",$texto);
		$texto = str_replace("¨","",$texto);
		$texto = str_replace("(","",$texto);
		$texto = str_replace(")","",$texto);
		$texto = str_replace("`","",$texto);
		$texto = str_replace("´","",$texto);
		$texto = str_replace("'","",$texto);
		$texto = str_replace("\"","",$texto);
		$texto = str_replace("\'","",$texto);
		$texto = str_replace("^","",$texto);
		$texto = str_replace("~","",$texto);
		$texto = str_replace("+","",$texto);
		return $texto;
	}

	/**
	* Remove caracteres não desejados
	* 
	* @author Cássio
	*
	* @name removerCaracteresPerigosos
	* @example removerCaracteresPerigosos("Olá! 100% de aproveitamento...");
	* @param string texto
	*	O texto para serem removidos os caracteres
	* @return string texto
	*/
	public static function removerCaracteresPerigosos($texto){
		$texto = str_replace("(","",$texto);
		$texto = str_replace(")","",$texto);
		$texto = str_replace("\"","",$texto);
		$texto = str_replace("\'","",$texto);
		$texto = str_replace("`","",$texto);
		$texto = str_replace("´","",$texto);
		$texto = str_replace("'","",$texto);
		//$texto = str_replace("+","",$texto);
		//$texto = str_replace("-","",$texto);
		//$texto = str_replace(">","",$texto);
		//$texto = str_replace("<","",$texto);
		$texto = str_replace("%","",$texto);
		$texto = str_replace(";","",$texto);
		$texto = str_replace("&","",$texto);
		$texto = str_replace("¨","",$texto);
		$texto = str_replace('"',"",$texto);
		return $texto;
	}
	
	/**
	* Formata o texto para utilização em URL
	* 
	* @author Douglas
	*
	* @name formatarParaUrl
	* @example formatarParaUrl("Atenção");
	* @param string texto
	*	O texto para ser removido os caracteres
	* @return string texto
	*/
	public static function formatarParaUrl($texto){
		$texto = html_entity_decode($texto, ENT_QUOTES, 'UTF-8');
		$texto = self::removerCaracteresEspeciais($texto);
		$texto = self::removerPontuacoes($texto);
		$texto = self::removerCaracteresPerigosos($texto);
		$texto = str_replace(" ", "-", $texto);
		$texto = str_replace(".", "", $texto);
		$texto = str_replace("/", "-", $texto);
		$texto = strtolower($texto);
		return $texto;
	}
	
	/**
	* Monta um tipo _FILES em array
	* 
	* Essa função deve ser chamada sempre antes de percorrer um array de _FILES 
	* pelo foreach() para montar objetos do tipo Foto
	*
	* @author Douglas
	*
	* @name montarFiles
	* @example montarFiles($_FILES['fotos']);
	* @param array vector
	* @return array
	*	Um array de _FILES
	*/
	public static function montarFiles(array $vector) { 
		$result = array(); 
		foreach($vector as $key1 => $value1) 
			foreach($value1 as $key2 => $value2) 
				$result[$key2][$key1] = $value2; 
		return $result; 
	}
	
	/**
	* Monta um texto a partir de um array
	*
	* @author Douglas
	*
	* @name arrayParaTexto
	* @example arrayParaTexto($meuArray);
	* @param array vector
	* @return String
	*/
	public static function arrayParaTexto(array $vector) { 
		$texto = "Array( ";
		foreach($vector as $key => $v){
			if(is_array($v))
				$texto .= " [".$key."] => ".self::arrayParaTexto($v)." ";
			else $texto .= " [".$key."] => ".$v." ";
		}
		$texto .= ")";
		return $texto;
	}
	
	/**
	* Exclui a pasta e todos os arquivos da mesma
	* 
	* @author Douglas
	*
	* @name excluirArquivos
	* @example excluirArquivos("/app/assets/images/dinamica/produto/3");
	* @param string dir
	*	Diretório a ser removido
	* @return bool
	*	false se houve algum erro ou true se funcionou como o esperado
	*/
	public static function excluirArquivos($dir1){
		global $_;
		if($dir1{0} != '/'){
			$dir1 = '/'.$dir1;
		}
		$dir = $_->raiz.$dir1;
		if(is_dir($dir)){
			if($handle = opendir($dir)){
				while(false !== ($file = readdir($handle))){
					if(($file == ".") or ($file == ".."))
						continue;
					if(is_dir($dir."/".$file))
						self::excluirArquivos($dir1."/".$file);
					else{
						chmod ($dir."/".$file, 0777);
						unlink($dir."/".$file);
					}
				}
			}else{
				return false;
			}
			closedir($handle);
		}else{
			return false;
		}
		return true;
	}
	
	/**
	 * Obtém todas as imagens dentro do diretório
	 * 
	 * @author Douglas
	 *
	 * @name todasAsImagenssNaPasta
	 * @example todasAsImagenssNaPasta("/app/assets/images/dinamica/produto/3");
	 * @param string diretorio
	 *	Diretório onde estão as fotos
	 * @param bool real
	 *	Se a imagen instanciada será aberta ou não em memória. (default to false)
	 * @return array Imagens
	 *	array de objetos do tipo Imagem
	 */
	public static function todasAsImagensNaPasta($diretorio, $real = false){
		global $_;
		if(substr($pasta, -1) == '/') {
			$pasta = substr($diretorio, 0, -1);
		}
		$pasta = $_->raiz . "/" . $diretorio;
		$imagens = array();
		if(is_dir($pasta)){
			if($pastaImagem = opendir($pasta)){
				while(false !== ($file = readdir($pastaImagem)))
					if($file!="." && $file!=".." && !is_dir($pasta."/".$file)){
						try{
							$img= ImagemFactory::carregarImagem($diretorio."/".$file, $real);
							array_push($imagens, $img);
						}catch(Exception $e){
							echo $e->getMessage();
						}
					}
				closedir($pastaImagem); 
			}
		}
		return $imagens;
	}
	
	/**
	* Obtém as coordenadas (latitude e longitude) de um endereço
	* 
	* @author Douglas
	*
	* @name obterCoordenadas
	* @example obterCoordenadas("Av. Antônio Mário de Azevedo, Nova Friburgo");
	* @param string endereco
	* @return array String
	*	array com 2 campos: Latitude(lat) e Longitude(lng)
	*/
	public static function obterCoordenadas($endereco){
		$endereco = str_replace(" ", "+", $endereco);
		$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$endereco.'&sensor=false');
		$output= json_decode($geocode);
		$lat = $output->results[0]->geometry->location->lat;
		$lng = $output->results[0]->geometry->location->lng;
		$coordenadas = array(
				"lat" => $lat,
				"lng" => $lng
			);
		return $coordenadas;
	}
	
	/**
	* Função que gera uma senha composta de letras minusculas, maiusculas, numeros e codigos de acordo com os parametros enviados
	*
	* @author Douglas
	* @author Igor
	*
	* @name gerarCodigo
	* @example gerarCodigo(4,true,true,false,false);
	* @param int tamanho
	*	tamanho desejado da senha 
	* @param bool maiuscula
	*	define se a senha terá letras maiúsculas
	* @param bool minuscula
	*	define se a senha terá letras minúsculas
	* @param bool numeros
	*	define se a senha terá números
	* @param bool codigos
	*	define se a senha terá códigos
	* @return String senha
	*/
	public static function gerarCodigo($tamanho = 8, $maiuscula = true, $minuscula = true, $numeros = true, $codigos = false){
		$maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
		$minus = "abcdefghijklmnopqrstuwxyz";
		$numer = "0123456789";
		$codig = '!@#$%&*()-+.,;?{[}]^><:|';
		
		$base = '';
		$base .= ($maiuscula) ? $maius : '';
		$base .= ($minuscula) ? $minus : '';
		$base .= ($numeros) ? $numer : '';
		$base .= ($codigos) ? $codig : '';

		$senha = '';
		for($i = 0; $i < $tamanho; $i++) {
			$senha .= substr($base, mt_rand(0, strlen($base)-1), 1);
		}
		return $senha;
	}
	
	/**
	* Transforma a data para uma data compatível com o banco de dados
	* 
	* @author Douglas
	*
	* @name dataParaBanco
	* @example dataParaBanco("24/03/1995");
	* @param string data
	* @return string data
	*/
	public static function dataParaBanco($data){
		return date("Y-m-d", strtotime(str_replace("/","-",$data)));
	}

	/**
	* Retorna um array com a quantidade de parcelas e o valor de
	* cada uma de acordo com os juros do cartão de crédito
	*
	* @author Cássio
	*
	* @name valorParcela
	* @example valorParcela(55,10,{'2'=>0.00,'3'=>1.00});
	* @ param float valor
	*	valor do produto
	* @param int sugestao
	*	número de parcelas sugeridas (a partir de onde começa a contar)
	* @param int parcelas
	*	relação entre o número de parcelas e sua respectiva tava de juros (%)
	* @return array['valorParcela','parcelas','juros']
	*/
	public static function valorParcela($valor, $sugestao = 18, $parcelas = array()){
		if($sugestao < 1)
			$sugestao = 1;

		if($valor < 10)
			return array('valorParcela' => $valor,'numeroParcelas' => '1', 'juros' => 0);
		
		$valorParcela = 0;

		do{
			$juros = $parcelas[$sugestao];

			$parcela = self::calcularParcela($valor,$sugestao,$juros);

			$sugestao--;
		}while($parcela['valorParcela'] < 5);

		return $parcela;
	}

	/**
	* Retorna um array com a quantidade de parcelas e o valor de
	* cada uma de acordo com os juros do cartão de crédito
	*
	* @author Cássio
	*
	* @name todosOsParcelamentosDisponiveis
	* @example todosOsParcelamentosDisponiveis(55,10,{'2'=>0.00,'3'=>1.00});
	* @ param float valor
	*	valor do produto
	* @param int sugestao
	*	número de parcelas sugeridas (a partir de onde começa a contar)
	* @param int parcelas
	*	relação entre o número de parcelas e sua respectiva tava de juros (%)
	* @return array
	*/
	public function todosOsParcelamentosDisponiveis($valor, $parcelaMaxima, $parcelas = array()){
		if($valor < 10 || $parcelaMaxima < 2)
			return array(array('valorParcela' => $valor,'numeroParcelas' => '1', 'juros' => 0));

		$retorno = array();
		$numeroParcelas = 2;

		while($numeroParcelas <= $parcelaMaxima){
			$parcela = self::calcularParcela($valor,$numeroParcelas,$parcelas[$numeroParcelas]);
			
			if($parcela['valorParcela'] < 5)
				break;

			array_push($retorno,$parcela);

			$numeroParcelas++;
		}

		return $retorno;
	}

	public function calcularParcela($valor,$numeroParcelas,$juros){
		$valor = ($valor+($valor*($juros/100)))/$numeroParcelas;
		return array('valorParcela' => number_format($valor,2,',','.'),'numeroParcelas' => $numeroParcelas, 'juros' => $juros);
	}
	
	
	/**
	* Funções para validações
	*/
	//-------------------------- VALIDAÇÕES ---------------------------//
	
	/**
	* Valida data
	*
	* @author Douglas
	*
	* @name validarData
	* @example validarData("26/05/1991");
	* @param string dat
	*	 no formato dd/mm/aaaa ou dd-mm-aaaa
	* @return bool verificacao
	*/
	public static function validarData($data){
		$data = html_entity_decode($data);
		$data = str_replace('-','/',$data);
		$data = explode("/","$data"); // fatia a string $data em pedados, usando / como referência
		$d = $data[0];
		$m = $data[1];
		$y = $data[2];
		$res = checkdate($m,$d,$y);
		if ($res == 1)
			return true;
		return false;
	}
	
	/**
	* Valida email
	*
	* @author Douglas
	*
	* @name validarEmail
	* @example validarEmail("fulano@hotmail.com");
	* @param string email
	* @return bool verificacao
	*/
	public static function validarEmail($email) {
		$email = html_entity_decode($email);
		$conta = "^[a-zA-Z0-9\._-]+@";
		$domino = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$^";
		$pattern = $conta.$domino.$extensao;
		if(preg_match($pattern, $email))
			return true;
		return false;
	}
	
	/**
	* Valida CPF em qualquer formato
	*
	* @author Douglas
	*
	* @name validarCPF
	* @example validarCPF("157.657.300-15");
	* @param string cpf
	*	 exemplo: no formato xxx.xxx.xxx-xx ou xxxxxxxxxxx
	* @return bool verificacao 
	*/
	public static function validarCPF($cpf){
		$cpf = html_entity_decode($cpf);
		$j = 0;
		for($i = 0; $i < (strlen($cpf)); $i++){
			if(is_numeric($cpf[$i])){
				$num[$j] = $cpf[$i];
				$j++;
			}
		}
		if(count($num) != 11){
			$isCpfValid = false;
		}else{
			for($i = 0; $i < 10; $i++){
				if($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i){
					$isCpfValid = false;
					break;
				}
			}
		}
		if(!isset($isCpfValid)){
			$j =10;
			for($i = 0; $i < 9; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$resto = $soma%11;
			if($resto < 2){
				$dg=0;
			}else{
				$dg = 11-$resto;
			}
			if($dg != $num[9]){
				$isCpfValid = false;
			}
		}
		if(!isset($isCpfValid)){
			$j=11;
			for($i = 0; $i < 10; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$resto = $soma%11;
			if($resto < 2){
				$dg = 0;
			}else{
				$dg = 11-$resto;
			}
			if($dg != $num[10]){
				$isCpfValid = false;
			}else{
				$isCpfValid = true;
			}
		}
		return $isCpfValid;
	}
	
	/**
	* Valida CNPJ em qualquer formato
	*
	* @author Douglas
	*
	* @name validarCNPJ
	* @example validarCNPJ("45.988.014/8246-22");
	* @param string cnpj
	*	 exemplo: no formato xx.xxx.xxx/xxxx-xx ou xxxxxxxxxxxxxx
	* @return bool verificacao 
	*/
	public static function validarCNPJ($cnpj){
		$cnpj = html_entity_decode($cnpj);
		$j = 0;
		for($i = 0; $i < (strlen($cnpj)); $i++){
			if(is_numeric($cnpj[$i])){
				$num[$j] = $cnpj[$i];
				$j++;
			}
		}
		if(count($num) != 14){
			$isCnpjValid = false;
		}
		if($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0){
			$isCnpjValid = false;
		}else{
			$j = 5;
			for($i = 0; $i < 4; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$j = 9;
			for($i = 4; $i < 12; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);	
			$resto = $soma%11;			
			if($resto < 2){
				$dg = 0;
			}else{
				$dg = 11-$resto;
			}
			if($dg != $num[12]){
				$isCnpjValid = false;
			} 
		}
		if(!isset($isCnpjValid)){
			$j = 6;
			for($i = 0; $i < 5; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$j = 9;
			for($i = 5; $i < 13; $i++){
				$multiplica[$i] = $num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);	
			$resto = $soma%11;			
			if($resto < 2){
				$dg = 0;
			}else{
				$dg = 11-$resto;
			}
			if($dg != $num[13]){
				$isCnpjValid = false;
			}else{
				$isCnpjValid  =true;
			}
		}
		return $isCnpjValid;
	}

	/**
	* Valida Inscrição Estadual em qualquer formato
	*
	* @author Mateus Machado
	*
	* @name validarIE
	* @example validarIE("01.004.823/001-12");
	* @return bool verificacao 
	*/

	function validarIE($ie, $uf){
		if( strtoupper($uf) == '' ){return false;}
		if( strtoupper($ie) == 'ISENTO' ){return 1;}
		else{
			$uf = strtoupper($uf);
			$ie = ereg_replace("[()-./,:]", "", $ie);
			$comando = '$valida = Util::CheckIE'.$uf.'("'.$ie.'");';
			eval($comando);
			return $valida;
		}
	}

	//Acre
	function CheckIEAC($ie){
		if (strlen($ie) != 13){return 0;}
		else{
			if(substr($ie, 0, 2) != '01'){return 0;}
			else{
				$b = 4;
				$soma = 0;
				for ($i=0;$i<=10;$i++){
					$soma += $ie[$i] * $b;
					$b--;
					if($b == 1){$b = 9;}
				}
				$dig = 11 - ($soma % 11);
				if($dig >= 10){$dig = 0;}
				if( !($dig == $ie[11]) ){return 0;}
				else{
					$b = 5;
					$soma = 0;
					for($i=0;$i<=11;$i++){
						$soma += $ie[$i] * $b;
						$b--;
						if($b == 1){$b = 9;}
					}
					$dig = 11 - ($soma % 11);
					if($dig >= 10){$dig = 0;}

					return ($dig == $ie[12]);
				}
			}
		}
	}

	// Alagoas
	function CheckIEAL($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != '24'){return 0;}
			else{
				$b = 9;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$soma *= 10;
				$dig = $soma - ( ( (int)($soma / 11) ) * 11 );
				if($dig == 10){$dig = 0;}

				return ($dig == $ie[8]);
			}
		}
	}

	//Amazonas
	function CheckIEAM($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			if($soma <= 11){$dig = 11 - $soma;}
			else{
				$r = $soma % 11;
				if($r <= 1){$dig = 0;}
				else{$dig = 11 - $r;}
			}

			return ($dig == $ie[8]);
		}
	}

	//Amapá
	function CheckIEAP($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != '03'){return 0;}
			else{
				$i = substr($ie, 0, -1);
				if( ($i >= 3000001) && ($i <= 3017000) ){$p = 5; $d = 0;}
				elseif( ($i >= 3017001) && ($i <= 3019022) ){$p = 9; $d = 1;}
				elseif ($i >= 3019023){$p = 0; $d = 0;}

				$b = 9;
				$soma = $p;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$dig = 11 - ($soma % 11);
				if($dig == 10){$dig = 0;}
				elseif($dig == 11){$dig = $d;}

				return ($dig == $ie[8]);
			}
		}
	}

	//Bahia
	function CheckIEBA($ie){
		if (strlen($ie) != 8){return 0;}
		else{

			$arr1 = array('0','1','2','3','4','5','8');
			$arr2 = array('6','7','9');

			$i = substr($ie, 0, 1);

			if(in_array($i, $arr1)){$modulo = 10;}
			elseif(in_array($i, $arr2)){$modulo = 11;}

			$b = 7;
			$soma = 0;
			for($i=0;$i<=5;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}

			$i = $soma % $modulo;
			if ($modulo == 10){
				if ($i == 0) { $dig = 0; } else { $dig = $modulo - $i; }
			}else{
				if ($i <= 1) { $dig = 0; } else { $dig = $modulo - $i; }
			}
			if( !($dig == $ie[7]) ){return 0;}
			else{
				$b = 8;
				$soma = 0;
				for($i=0;$i<=5;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$soma += $ie[7] * 2;
				$i = $soma % $modulo;
				if ($modulo == 10){
					if ($i == 0) { $dig = 0; } else { $dig = $modulo - $i; }
				}else{
					if ($i <= 1) { $dig = 0; } else { $dig = $modulo - $i; }
				}

				return ($dig == $ie[6]);
			}
		}
	}

	//Ceará
	function CheckIECE($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$dig = 11 - ($soma % 11);

			if ($dig >= 10){$dig = 0;}

			return ($dig == $ie[8]);
		}
	}

	// Distrito Federal
	function CheckIEDF($ie){
		if (strlen($ie) != 13){return 0;}
		else{
			if( substr($ie, 0, 2) != '07' ){return 0;}
			else{
				$b = 4;
				$soma = 0;
				for ($i=0;$i<=10;$i++){
					$soma += $ie[$i] * $b;
					$b--;
					if($b == 1){$b = 9;}
				}
				$dig = 11 - ($soma % 11);
				if($dig >= 10){$dig = 0;}

				if( !($dig == $ie[11]) ){return 0;}
				else{
					$b = 5;
					$soma = 0;
					for($i=0;$i<=11;$i++){
						$soma += $ie[$i] * $b;
						$b--;
						if($b == 1){$b = 9;}
					}
					$dig = 11 - ($soma % 11);
					if($dig >= 10){$dig = 0;}

					return ($dig == $ie[12]);
				}
			}
		}
	}

	//Espirito Santo
	function CheckIEES($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$i = $soma % 11;
			if ($i < 2){$dig = 0;}
			else{$dig = 11 - $i;}

			return ($dig == $ie[8]);
		}
	}

	//Goias
	function CheckIEGO($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$s = substr($ie, 0, 2);

			if( !( ($s == 10) || ($s == 11) || ($s == 15) ) ){return 0;}
			else{
				$n = substr($ie, 0, 7);

				if($n == 11094402){
					if($ie[8] != 0){
						if($ie[8] != 1){
							return 0;
						}else{return 1;}
					}else{return 1;}
				}else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $ie[$i] * $b;
						$b--;
					}
					$i = $soma % 11;
					if ($i == 0){$dig = 0;}
					else{
						if($i == 1){
							if(($n >= 10103105) && ($n <= 10119997)){$dig = 1;}
							else{$dig = 0;}
						}else{$dig = 11 - $i;}
					}

					return ($dig == $ie[8]);
				}
			}
		}
	}

	// Maranhão
	function CheckIEMA($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != 12){return 0;}
			else{
				$b = 9;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$i = $soma % 11;
				if ($i <= 1){$dig = 0;}
				else{$dig = 11 - $i;}

				return ($dig == $ie[8]);
			}
		}
	}

	// Mato Grosso
	function CheckIEMT($ie){
		if (strlen($ie) != 11){return 0;}
		else{
			$b = 3;
			$soma = 0;
			for($i=0;$i<=9;$i++){
				$soma += $ie[$i] * $b;
				$b--;
				if($b == 1){$b = 9;}
			}
			$i = $soma % 11;
			if ($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}

			return ($dig == $ie[10]);
		}
	}

	// Mato Grosso do Sul
	function CheckIEMS($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != 28){return 0;}
			else{
				$b = 9;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$i = $soma % 11;
				if ($i == 0){$dig = 0;}
				else{$dig = 11 - $i;}

				if($dig > 9){$dig = 0;}

				return ($dig == $ie[8]);
			}
		}
	}

	//Minas Gerais
	function CheckIEMG($ie){
		if (strlen($ie) != 13){return 0;}
		else{
			$ie2 = substr($ie, 0, 3) . '0' . substr($ie, 3);

			$b = 1;
			$soma = "";
			for($i=0;$i<=11;$i++){
				$soma .= $ie2[$i] * $b;
				$b++;
				if($b == 3){$b = 1;}
			}
			$s = 0;
			for($i=0;$i<strlen($soma);$i++){
				$s += $soma[$i];
			}
			$i = substr($ie2, 9, 2);
			$dig = $i - $s;
			if($dig != $ie[11]){return 0;}
			else{
				$b = 3;
				$soma = 0;
				for($i=0;$i<=11;$i++){
					$soma += $ie[$i] * $b;
					$b--;
					if($b == 1){$b = 11;}
				}
				$i = $soma % 11;
				if($i < 2){$dig = 0;}
				else{$dig = 11 - $i;};

				return ($dig == $ie[12]);
			}
		}
	}

	//Pará
	function CheckIEPA($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != 15){return 0;}
			else{
				$b = 9;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$i = $soma % 11;
				if ($i <= 1){$dig = 0;}
				else{$dig = 11 - $i;}

				return ($dig == $ie[8]);
			}
		}
	}

	//Paraíba
	function CheckIEPB($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$i = $soma % 11;
			if ($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}

			if($dig > 9){$dig = 0;}

			return ($dig == $ie[8]);
		}
	}

	//Paraná
	function CheckIEPR($ie){
		if (strlen($ie) != 10){return 0;}
		else{
			$b = 3;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
				if($b == 1){$b = 7;}
			}
			$i = $soma % 11;
			if ($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}

			if ( !($dig == $ie[8]) ){return 0;}
			else{
				$b = 4;
				$soma = 0;
				for($i=0;$i<=8;$i++){
					$soma += $ie[$i] * $b;
					$b--;
					if($b == 1){$b = 7;}
				}
				$i = $soma % 11;
				if($i <= 1){$dig = 0;}
				else{$dig = 11 - $i;}

				return ($dig == $ie[9]);
			}
		}
	}

	//Pernambuco
	function CheckIEPE($ie){
		if (strlen($ie) == 9){
			$b = 8;
			$soma = 0;
			for($i=0;$i<=6;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$i = $soma % 11;
			if ($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}

			if ( !($dig == $ie[7]) ){return 0;}
			else{
				$b = 9;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b--;
				}
				$i = $soma % 11;
				if ($i <= 1){$dig = 0;}
				else{$dig = 11 - $i;}

				return ($dig == $ie[8]);
			}
		}
		elseif(strlen($ie) == 14){
			$b = 5;
			$soma = 0;
			for($i=0;$i<=12;$i++){
				$soma += $ie[$i] * $b;
				$b--;
				if($b == 0){$b = 9;}
			}
			$dig = 11 - ($soma % 11);
			if($dig > 9){$dig = $dig - 10;}

			return ($dig == $ie[13]);
		}
		else{return 0;}
	}

	//Piauí
	function CheckIEPI($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$i = $soma % 11;
			if($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}
			if($dig >= 10){$dig = 0;}

			return ($dig == $ie[8]);
		}
	}

	// Rio de Janeiro
	function CheckIERJ($ie){
		if (strlen($ie) != 8){return 0;}
		else{
			$b = 2;
			$soma = 0;
			for($i=0;$i<=6;$i++){
				$soma += $ie[$i] * $b;
				$b--;
				if($b == 1){$b = 7;}
			}
			$i = $soma % 11;
			if ($i <= 1){$dig = 0;}
			else{$dig = 11 - $i;}

			return ($dig == $ie[7]);
		}
	}

	//Rio Grande do Norte
	function CheckIERN($ie){
		if( !( (strlen($ie) == 9) || (strlen($ie) == 10) ) ){return 0;}
		else{
			$b = strlen($ie);
			if($b == 9){$s = 7;}
			else{$s = 8;}
			$soma = 0;
			for($i=0;$i<=$s;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$soma *= 10;
			$dig = $soma % 11;
			if($dig == 10){$dig = 0;}

			$s += 1;
			return ($dig == $ie[$s]);
		}
	}

	// Rio Grande do Sul
	function CheckIERS($ie){
		if (strlen($ie) != 10){return 0;}
		else{
			$b = 2;
			$soma = 0;
			for($i=0;$i<=8;$i++){
				$soma += $ie[$i] * $b;
				$b--;
				if ($b == 1){$b = 9;}
			}
			$dig = 11 - ($soma % 11);
			if($dig >= 10){$dig = 0;}

			return ($dig == $ie[9]);
		}
	}

	// Rondônia
	function CheckIERO($ie){
		if (strlen($ie) == 9){
			$b=6;
			$soma =0;
			for($i=3;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$dig = 11 - ($soma % 11);
			if($dig >= 10){$dig = $dig - 10;}

			return ($dig == $ie[8]);
		}
		elseif(strlen($ie) == 14){
			$b=6;
			$soma=0;
			for($i=0;$i<=12;$i++) {
				$soma += $ie[$i] * $b;
				$b--;
				if($b == 1){$b = 9;}
			}
			$dig = 11 - ( $soma % 11);
			if ($dig > 9){$dig = $dig - 10;}

			return ($dig == $ie[13]);
		}
		else{return 0;}
	}

	//Roraima
	function CheckIERR($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			if(substr($ie, 0, 2) != 24){return 0;}
			else{
				$b = 1;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b++;
				}
				$dig = $soma % 9;

				return ($dig == $ie[8]);
			}
		}
	}

	//Santa Catarina
	function CheckIESC($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$dig = 11 - ($soma % 11);
			if ($dig <= 1){$dig = 0;}

			return ($dig == $ie[8]);
		}
	}

	//São Paulo
	function CheckIESP($ie){
		if( strtoupper( substr($ie, 0, 1) )  == 'P' ){
			if (strlen($ie) != 13){return 0;}
			else{
				$b = 1;
				$soma = 0;
				for($i=1;$i<=8;$i++){
					$soma += $ie[$i] * $b;
					$b++;
					if($b == 2){$b = 3;}
					if($b == 9){$b = 10;}
				}
				$dig = $soma % 11;
				return ($dig == $ie[9]);
			}
		}else{
			if (strlen($ie) != 12){return 0;}
			else{
				$b = 1;
				$soma = 0;
				for($i=0;$i<=7;$i++){
					$soma += $ie[$i] * $b;
					$b++;
					if($b == 2){$b = 3;}
					if($b == 9){$b = 10;}
				}
				$dig = $soma % 11;
				if($dig > 9){$dig = 0;}

				if($dig != $ie[8]){return 0;}
				else{
					$b = 3;
					$soma = 0;
					for($i=0;$i<=10;$i++){
						$soma += $ie[$i] * $b;
						$b--;
						if($b == 1){$b = 10;}
					}
					$dig = $soma % 11;

					return ($dig == $ie[11]);
				}
			}
		}
	}

	//Sergipe
	function CheckIESE($ie){
		if (strlen($ie) != 9){return 0;}
		else{
			$b = 9;
			$soma = 0;
			for($i=0;$i<=7;$i++){
				$soma += $ie[$i] * $b;
				$b--;
			}
			$dig = 11 - ($soma % 11);
			if ($dig > 9){$dig = 0;}

			return ($dig == $ie[8]);
		}
	}

	//Tocantins
	function CheckIETO($ie){
		if (strlen($ie) != 11){return 0;}
		else{
			$s = substr($ie, 2, 2);
			if( !( ($s=='01') || ($s=='02') || ($s=='03') || ($s=='99') ) ){return 0;}
			else{
				$b=9;
				$soma=0;
				for($i=0;$i<=9;$i++){
					if( !(($i == 2) || ($i == 3)) ){
						$soma += $ie[$i] * $b;
						$b--;
					}
				}
				$i = $soma % 11;
				if($i < 2){$dig = 0;}
				else{$dig = 11 - $i;}

				return ($dig == $ie[10]);
			 }
		}
	}

	/**
	* Valida um campo numério
	* Verifica se está preenchido o campo, se o valor é numérico e se é maior que 0
	*
	* @author Douglas
	*
	* @name validarCampoNumerico
	* @example validarCampoNumerico(47.76);
	* @param unknown_type valor
	* @return bool verificacao 
	*/
	public static function validarCampoNumerico($valor){
		if(strlen(html_entity_decode($valor)) < 0)
			return false;
		elseif(!is_numeric($valor))
			return false;
		elseif($valor < 0)
			return false;
		return true;
	}
	
	
	/**
	* Função que valida se um texto está no formato de um número hexadecimal
	*
	* @author Douglas
	*
	* @name validarHexadecimal
	* @example validarHexadecimal("#4466dd");
	* @param unknown_type hexadecimal
	* @return bool verificacao 
	*/
	public static function validarHexadecimal($hexadecimal){
		$hexadecimal = html_entity_decode($hexadecimal);
		if(preg_match('/^#(?:(?:[a-f\d]{3}){1,2})$/i', $hexadecimal)){
			return true;
		}
		return false;
	}
	
	//----------------------- END VALIDAÇÕES --------------------------//

	//-------------------------- VIDEOS ---------------------------//
	
	/**
	* Verifica site de origem do video
	*
	* @author Jose
	*
	* @name siteOrigemVideo
	* @example validarData("http://www.youtube.com/watch?v=pK2zYHWDZKo");
	* @param string video
	* @return string "site do video"
	*/

	public static function siteOrigemVideo($video){
		if(strpos($video,"vimeo") !== false)
			return "vimeo";
		elseif(strpos($video,"youtube") !== false)
			return "youtube";
		else return "";
	}

	/**
	* Transforma a URL no video
	*
	* @author Jose
	*
	* @name video
	* @example video("http://www.youtube.com/watch?v=pK2zYHWDZKo");
	* @param string video
	* @return string video sem URL ("pK2zYHWDZKo")
	*/
	
	public static function video($video){
		$site = self::siteOrigemVideo($video);
		if($site == "youtube"){
			$video = explode("v=",$video);
			$video = explode("&",$video[1]);
			$video = $video[0];
		}
		elseif($site == "vimeo"){
			$video = explode("vimeo.com/",$video);
			$video = $video[count($video)-1];
		}
		return $video;
	}

	/**
	* Transforma a URL em codigo HTML
	*
	* @author Jose
	*
	* @name gerarVideoHTML
	* @example gerarVideoHTML("http://www.youtube.com/watch?v=pK2zYHWDZKo");
	* @param string video
	* @return string video em HTML
	*/
	
	public static function gerarVideoHTML($video, $largura='480', $altura='360'){
		$site = self::siteOrigemVideo($video);
		if($site == "youtube")
			$video = '<iframe width="'.$largura.'" height="'.$altura.'" src="//www.youtube.com/embed/'.self::video($video).'" frameborder="0" allowfullscreen></iframe>';
		elseif($site == "vimeo")
			$video = "<iframe src='http://player.vimeo.com/video/".self::video($video)."?title=0&amp;byline=0&amp;portrait=0&amp;color=d13030' width='".$largura."' height='".($largura*0.59)."' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
		return $video;
	}
	
	/**
	* Transforma a URL em codigo HTML
	*
	* @author Jose
	*
	* @name gerarThumbHTML
	* @example gerarThumbHTML("http://www.youtube.com/watch?v=pK2zYHWDZKo");
	* @param string video
	* @return string video em HTML
	*/

	public static function gerarThumbVideo($video){
		$url_imagem = parse_url($video);
		if($url_imagem['host'] == 'www.youtube.com' || $url_imagem['host'] == 'youtube.com'){
			$array = explode("&", $url_imagem['query']);
			return "http://img.youtube.com/vi/".substr($array[0], 2)."/0.jpg";
		} else if($url_imagem['host'] == 'www.vimeo.com' || $url_imagem['host'] == 'vimeo.com'){
			$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".substr($url_imagem['path'], 1).".php"));
			return $hash[0]["thumbnail_small"];
		}
	}

	//----------------------- END VIDEOS --------------------------//
	/**
	* dada uma data inicial e uma data final é calculado o percentual de tempo decorrido até dia atual por default
	* caso seja passado uma data como parametro opcional, é calculado o percentual de tempo decorrido até a data em questão
	* @author Jose
	*
	* @name calcularPercentualTempoDecorrido
	* @example calcularPercentualTempoDecorrido('12/03/2013','12,04/2013');
	* @param
	* string dataInicial, string dataFinalm string data(opcional) OBS: As entradas devem ser reconhecidas pela função strtotime
	* @return inteiro percentualDecorrido de 0 a 100
	*/
	public static function calcularPercentualTempoDecorrido($dataInicial, $dataFinal, $data = null){
		$format = 'Y-m-d H:i:s';
		if($data == null){
			$data = strtotime(date($format));
		}
		else{
			$data = strtotime(date($format, strtotime($data)));
		}
		$dataInicial = strtotime(date($format, strtotime($dataInicial)));
		$dataFinal = strtotime(date($format, strtotime($dataFinal)));
		$diasRestantes = $dataFinal - $data;
		$diasTotais = $dataFinal - $dataInicial;
		$percentualDecorrido = (1 - $diasRestantes / $diasTotais)*100;
		if($percentualDecorrido < 0 || $percentualDecorrido > 100){
			return 100;
		}
		else{
			return $percentualDecorrido;
		}
	}

	/**
	* Adiciona um caractere na string na posição enviada
	* @author Jose
	*
	* @name strInsert
	* @example strInsert("-", $cep, 5);
	* @param
	* 	$insertstring - the string you want to insert
	* 	$intostring - the string you want to insert it into
	* 	$offset - the offset
	* @return string caractere incluído
	*/
	 
	public static function strInsert($insertstring, $intostring, $offset) {
	   $part1 = substr($intostring, 0, $offset);
	   $part2 = substr($intostring, $offset);
	 
	   $part1 = $part1 . $insertstring;
	   $whole = $part1 . $part2;
	   
	   return $whole;
	}

	/**
	 * [base64_encode_image Retorna a codificação base-64 da imagem]
	 * @param  string $filename [Caminho e nome do arquivo]
	 * @param  string $filetype [Tipo do arquivo]
	 * @return string		   [Base-64 do arquivo]
	 */
	public static function base64EncodeImage($filename = "", $filetype = "png") {
		if($filename){
			$imgbinary = fread(fopen($filename, "r"), filesize($filename));
			return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
		}
	}

	/**
	 * [set404Page Adiciona às configurações do boilerplate a página 404]
	 * @return void()
	 */
	public static function set404Page(){
		global $_;
		if($_->usingTwig){
			$_->bodyClass = "page-404";
			$container = $_->raiz.'/'.$_->appViewsPath.'/'.$_->folder."/404.tmpl";
			if(file_exists($container)){
				$container = $_->folder."/404.tmpl";
				$_->container = $container;
			}else $_->container = '/errors/404.tmpl';
		}else{
			$_->bodyClass = "page-404";
			$container = $_->raiz.'/'.$_->appViewsPath.'/'.$_->folder."/404.php";
			if(file_exists($container)){
				$_->container = $container;
			}else $_->container = $_->raiz.'/'.$_->appViewsPath.'/errors/404.php';
		}
	}

	public static function calculaFrete($servico, $CEPorigem, $CEPdestino, $peso, $valor='1.00', $altura='5', $largura='11', $comprimento='16'){
		////////////////////////////////////////////////
		// Código dos Serviços dos Correios
		// 41106 PAC
		// 40010 SEDEX
		// 40045 SEDEX a Cobrar
		// 40215 SEDEX 10
		////////////////////////////////////////////////
		// URL do WebService
		$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=14526409&sDsSenha=20728797&sCepOrigem=".$CEPorigem."&sCepDestino=".$CEPdestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=".$servico."&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
		// Carrega o XML de Retorno
		$xml = simplexml_load_file($correios);
		return json_decode(json_encode($xml->cServico));
	}
	
	public static function logException($e) {
		$exception = array(
			"mensagem" => $e->getMessage(),
			"trace" => $e->getTraceAsString(),
			"arquivo" => $e->getFile() 
		);
		$opsController = Util::makeController('ops');
		$ops = $opsController->criarOps($exception);
		$opsController->salvar($ops);
	}

	public static function imagesSizes($context){
		global $_;
		$url = $_->raiz."/app/_sizes.json";
		$json = file_get_contents($url);
		$_data = json_decode($json, TRUE);
		if(function_exists("json_last_error") && json_last_error() != JSON_ERROR_NONE){
			throw new LogicException("O JSON _sizes contém um erro");
		}
		foreach($_data as $key => $d){
			if($d['context'] == $context){
				return $d['sizes'];
			}
		}
		return array();
	}
	
	public static function getListaEmail() {
		global $_;
		$url = $_->raiz."/app/_data.json";
		$json = file_get_contents($url);
		$_data = json_decode($json, TRUE);
		if(function_exists("json_last_error") && json_last_error() != JSON_ERROR_NONE){
			throw new LogicException("O JSON _data contém um erro");
		}
		return $_data['listaEmail'];
		
	}
	
	public static function getOpcoesBanco($banco) {
	
		global $_;
		$url = $_->raiz."/app/_banco.json";
		$json = file_get_contents($url);
		$_data = json_decode($json, TRUE);
		if(function_exists("json_last_error") && json_last_error() != JSON_ERROR_NONE){
			throw new LogicException("O JSON _banco contém um erro");
		}
		return $_data[$banco];
	}

	public static function sqlAddSlashes( $a_string = '', $is_like = false ) {
		if ( $is_like )
			$a_string = str_replace( '\\', '\\\\\\\\', $a_string );

		else
			$a_string = str_replace( '\\', '\\\\', $a_string );

		$a_string = str_replace( '\'', '\\\'', $a_string );

		return $a_string;
	}

	public static function sqlBackQuote( $a_name ) {
		if ( ! empty( $a_name ) && $a_name !== '*' ) {
			if ( is_array( $a_name ) ) {
				$result = array();
				reset( $a_name );
				while ( list( $key, $val ) = each( $a_name ) )
					$result[$key] = '`' . $val . '`';
				return $result;
			} else {
				return '`' . $a_name . '`';
			}
		} else {
			return $a_name;
		}
	}

	public static function removeAccents($string) {
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;

		if (seems_utf8($string)) {
			$chars = array(
			// Decompositions for Latin-1 Supplement
			chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
			chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
			chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
			chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
			chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
			chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
			chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
			chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
			chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
			chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
			chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
			chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
			chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
			chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
			chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
			chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
			chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
			chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
			chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
			chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
			chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
			chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
			chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
			chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
			chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
			chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
			chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
			chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
			chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
			chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
			chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
			chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
			// Decompositions for Latin Extended-A
			chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
			chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
			chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
			chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
			chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
			chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
			chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
			chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
			chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
			chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
			chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
			chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
			chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
			chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
			chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
			chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
			chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
			chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
			chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
			chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
			chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
			chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
			chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
			chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
			chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
			chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
			chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
			chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
			chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
			chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
			chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
			chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
			chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
			chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
			chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
			chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
			chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
			chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
			chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
			chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
			chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
			chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
			chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
			chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
			chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
			chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
			chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
			chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
			chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
			chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
			chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
			chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
			chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
			chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
			chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
			chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
			chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
			chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
			chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
			chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
			chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
			chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
			chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
			chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
			// Decompositions for Latin Extended-B
			chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
			chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
			// Euro Sign
			chr(226).chr(130).chr(172) => 'E',
			// GBP (Pound) Sign
			chr(194).chr(163) => '',
			// Vowels with diacritic (Vietnamese)
			// unmarked
			chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
			chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
			// grave accent
			chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
			chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
			chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
			chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
			chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
			chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
			chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
			// hook
			chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
			chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
			chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
			chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
			chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
			chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
			chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
			chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
			chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
			chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
			chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
			chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
			// tilde
			chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
			chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
			chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
			chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
			chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
			chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
			chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
			chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
			// acute accent
			chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
			chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
			chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
			chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
			chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
			chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
			// dot below
			chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
			chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
			chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
			chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
			chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
			chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
			chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
			chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
			chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
			chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
			chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
			chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
			// Vowels with diacritic (Chinese, Hanyu Pinyin)
			chr(201).chr(145) => 'a',
			// macron
			chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
			// acute accent
			chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
			// caron
			chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
			chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
			chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
			chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
			chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
			// grave accent
			chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
			);
	
			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);
	
			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
	
			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}
	
		return $string;
	}

	public static function trailingslashit($string) {
		return Util::untrailingslashit($string) . '/';
	}
	
	public static function untrailingslashit($string) {
		return rtrim($string, '/');
	}

	public static function conformDir( $dir, $recursive = false ) { //util
		if ( ! $dir )
			$dir = '/';
		$dir = str_replace( '\\', '/', $dir );
		$dir = str_replace( '//', '/', $dir );
		if ( $dir !== '/' )
			$dir = Util::untrailingslashit( $dir );
		if ( ! $recursive && Util::conformDir( $dir, true ) != $dir )
			return $this->conformDir( $dir );
		return (string) $dir;
	}

}
?>