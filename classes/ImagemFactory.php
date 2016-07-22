<?php
global $_;

/*
 *  ImageFactory
 *
 * Divisao do objeto foto e logica de imagem/arquivos
 * Construзгo, manipulaзao e gerenciamento de imagens
 */
 
 class ImagemFactory {

 	const UTILIZA_S3 = false;
 
	/*
	 *	Carrega uma imagem como objeto Imagem
	 *
	 * @caminho - Caminho da imagem
	 * @data -  carregar imagem pra memoria
	 */
	public static function carregarImagem($caminho, $data = false, $raiz = true) {
		if($data) {
			$imagem = new Imagem($caminho, $data, $raiz);
			if($imagem->getImagem() === false || $imagem->getImagem() === null) {
				throw new RunTimeException("Nao foi possivel carregar a imagem");
			} else {
				return $imagem;
			}
		} else {
			return new Imagem($caminho, $data, $raiz);
		}
	}
	
	/*
	 *	Carrega uma imagem como objeto ImagemAlbum
	 *
	 * @caminho - Caminho da imagem
	 * @data -  carregar imagem pra memoria
	 */
	public static function carregarImagemAlbum($caminho, $data = false, $raiz = true) {
		if($data) {
			$imagemAlbum = new ImagemAlbum($caminho, $data, $raiz);
			if($imagemAlbum->getImagem() === false || $imagemAlbum->getImagem() === null) {
				throw new RunTimeException("Nao foi possivel carregar a imagem");
			} else {
				return $imagemAlbum;
			}
		} else {
			return new ImagemAlbum($caminho, $data, $raiz);
		}
	}
	
	/*
	 *	Low-level salvar imagem  do arquivo, check basico + copiar/mover arquivo e extensao
	 * Se o arquivo foi salvo com sucesso retorna o caminho onde foi salvo se nao retorna falso
	 */
	private static function salvarImagemDoArquivo($caminho, $novo_caminho,  $upload = false) {

		$dir = dirname($novo_caminho);
		if($dir != '' && !is_dir($dir)) {
			mkdir($dir, 0777, true);
		}

		if($upload ) {	
			return move_uploaded_file($caminho, $novo_caminho);
		} else {
			return copy($caminho, $novo_caminho);
		}
		return false;
	}
	
	/*
	 *	Low-level salvar imagem da memoria, check basico + escrever arquivo e extensao
	 * Se o arquivo foi salvo com sucesso retorna o caminho onde foi salvo se nao retorna falso
	 */
	public static function salvarImagemDaMemoria(&$imagem, $novo_caminho, $mime_type, $qualidade = 80) {
		$dir = dirname($novo_caminho);
		if($dir != '' && !is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		//remove extensao
		$novo_caminho= preg_replace('/\\.[^.\\s]{3,5}$/', '', $novo_caminho);

		switch($mime_type) {
			case "image/gif": 
				$novo_caminho .= '.gif';
				$enviou = imagegif($imagem, $novo_caminho);
				break;
			case "image/jpeg" : 
			case "image/png" : 
				$novo_caminho .= '.jpg';
				$enviou = imagejpeg($imagem, $novo_caminho,$qualidade);
				break;
			//case "image/png" : 
				//$novo_caminho .= '.png';
				//return imagepng($imagem, $novo_caminho);
			case "image/x-ms-bmp":
			//caso confundao com a extensao
			case "image/bmp":
				$novo_caminho .= '.bmp';
				$enviou = ImagemFactory::imagebmp($imagem, $novo_caminho);
				break;
			default:
				$novo_caminho .= '.jpg';
				$enviou = imagejpeg($imagem, $novo_caminho,$qualidade);
		}

		if(self::UTILIZA_S3 && (strpos($novo_caminho,'produto') !== false || strpos($novo_caminho,'album') !== false)){
			return self::salvarS3($novo_caminho);
		}

		if($enviou){
			return end(explode('/', $novo_caminho));
		}
		return $enviou;
	}

	public static function salvarS3($caminho){

		if(strpos($caminho,'produto') !== false){
			$objeto = 'produto';
		}
		else{
			$objeto = 'album';
		}

		$imagem = fopen($caminho,'rb');
		$array = explode('/',$caminho);
		$contagem = count($array);
		$s3 = new AwsS3API($objeto);
		$pastaPadrao = $s3->getPastaPadrao();

		if($objeto == 'produto'){
			if(substr($array[$contagem-2], 0, 3) == 'cor')
				$nomeS3 = $pastaPadrao.end($array);
			else
				$nomeS3 = $pastaPadrao.$array[$contagem-2].'/'.end($array);
		}else{
			if($array[10] == 'thumb')
				$nomeS3 = $pastaPadrao.'thumb/'.end($array);
			else
				$nomeS3 = $pastaPadrao.end($array);
		}
		
		$resultado = $s3->salvarImagem($imagem,$nomeS3);
		if($resultado['ObjectURL'] == '')
			return false;
		return $resultado['ObjectURL'];
	}
	
	private function mimeToExt($mime) {
		switch($mime) {
				case "image/gif": 
					return "gif";
				case "image/jpeg" : 
					return "jpg";
				case "image/png" : 
					return "png";
				case "image/x-ms-bmp":
					return "bmp";
				default:
					return false;
			}
	}
	
	public function getImagemExt($caminho) {
	
		$size = getimagesize($caminho);
		if($size === false) {
			return false;
		} else {
			return ImagemFactory::mimeToExt($size['mime']);
		}
	}
	/*
	 * Salva arquivo com a estrutura do php $_FILES na $pasta, gera nome/ redimensiona etc
	 *
	 * @arquivo -  arquivo do tipo $_FILES
	 * @pasta -  pasta de destino
	 * @nome - nome opcional
	 * @options -  array com altura/largura/[sub_pasta/manter_aspecto/formato]
	 * @coordenadas - array com x, y, altura e largura para crop da imagem, tendo o mesmo index de $arquivos
	 * @retorna - array com nome original, novo nome e status(sucesso) se foi salvo, se nenhuma imagem foi salva retorna falso
	 */
	public static function salvarImagens($arquivos, $pasta, $nome = '', $options = array(), $coordenadas = null) {

		$imagens = array();
		$sucesso = true;
		$quantidadeFalha = 0;
		
		if(substr($pasta, -1) != '/') {
			$pasta .= '/';
		}

		if(is_array($arquivos['name']))
			$files = Util::montarFiles($arquivos);
		else
			$files = array(0 => $arquivos);

		foreach($files as $k => $file){
			if($file['name'] != "") {
			
				if($file['tmp_name'] == "") {
					array_push($novos_nomes, array( 'original' => $file['name'], 'novo' => "",  'sucesso' => false));
					continue;
				}
				
				if($error != UPLOAD_ERR_OK) {
					array_push($novos_nomes, array( 'original' => $file['name'], 'novo' => "",  'sucesso' => false));
					continue;
				}
				
				$ext = ImagemFactory::getImagemExt($file['tmp_name']);
				if($ext === false) {
					array_push($novos_nomes, array( 'original' => $file['name'], 'novo' => "",  'sucesso' => false));
					continue;
				}
				
				/*$id = 0;
				if(is_dir($pasta)) {
					$id = ImagemFactory::gerarId($pasta);
				}*/
				$id = substr(uniqid(2),-6);
				
				if($nome == '') {
					$novo_nome = ImagemFactory::gerarNome($file['name'], $id);
				} else {
					$novo_nome = ImagemFactory::gerarNome($nome, $id);
				}
				
				if(count($options) > 0) {
					foreach($options as $opt) {
						if(isset($opt['altura']) || isset($opt['largura'])) {
							$imagem = ImagemFactory::carregarImagem($file['tmp_name'], true, false);

							$data = $imagem->getImagem();
							
							if(isset($coordenadas) && isset($coordenadas) && count($coordenadas) == 4) {
								$data = ImagemFactory::crop($data, $coordenadas[0], $coordenadas[1], $coordenadas[2], $coordenadas[3]);
							}
							
							$alpha = null;
							if(isset($opt['alpha'])) {
								$alpha = $opt['alpha'];
							}
							
							$bg_color = null;
							if(isset($opt['bg_color'])) {
								$bg_color = $opt['bg_color'];
							}
							
							$keepAsp = null;
							if(isset($opt['manter_aspecto'])) {
								$keepAsp = $opt['manter_aspecto'];
							}
							if($opt['largura'] != null && $opt['altura'] != null)
								$data = ImagemFactory::redimensionar($data, $opt['largura'], $opt['altura'], $keepAsp, $alpha, $bg_color);
							
							$sub_pasta = '';
							if(isset($opt['sub_pasta'])) {
								$sub_pasta = $opt['sub_pasta'] . '/';
							}
							
							if(isset($opt['formato'])) {
								$formato = $opt['formato'];
							} else {
								$formato = $file['type'];
							}

							$qualidade = 80;
							if(isset($opt['qualidade'])){
								$qualidade = $opt['qualidade'];
							}

							$ext = ImagemFactory::mimeToExt($formato);
							if($ext !== false) {
								$resultado = ImagemFactory::salvarImagemDaMemoria($data, $pasta . $sub_pasta . $novo_nome, $formato, $qualidade);
							} else {
								throw new InvalidArgumentException("Formato invalido para salvar imagem: " . $formato);
							}
							imagedestroy($data);
						} else {
							throw new InvalidArgumentException("Opções invalidas para salvar imagem: " . $file['name']);
						}
					}
				//Se nao tem opçoes
				} else {
					if(isset($coordenadas) && count($coordenadas) == 4) {
						$data = ImagemFactory::carregarImagem($file['tmp_name'], true, false)->getImagem();
						$data = ImagemFactory::crop($data, $coordenadas[0], $coordenadas[1], $coordenadas[2], $coordenadas[3]);
						$formato = $file['type'];
						$ext = ImagemFactory::mimeToExt($formato);
						if($ext !== false) {
							$resultado = ImagemFactory::salvarImagemDaMemoria($data, $pasta . $novo_nome, $formato);
						}
					} else {
						$resultado = ImagemFactory::salvarImagemDoArquivo($file['tmp_name'], $pasta . $novo_nome . "." . $ext, is_uploaded_file($file['tmp_name']));
					}
				}
				
				if($resultado === false) {
					$sucesso = false;
					$quantidadeFalha++;
				} else {
					array_push($imagens, end(explode('/',$resultado)));
				}
			}
		}
		
		if($quantidadeFalha > 0 && count($imagens) > 0) {
			$resposta = new Response($sucesso, 'Imagens com erro ao enviar: '.$quantidade, $imagens);
		} elseif($sucesso == true) {
			$resposta = new Response($sucesso, 'Imagens enviadas com sucesso', $imagens);
		} else {
			$resposta = new Response($sucesso, 'Imagens com erro ao enviar: '.$quantidade, $imagens);
		}

		return $resposta;
	}
	
	/*
	 *	Gera nome padrao dado nome real e id
	 * OBS: nao gera nome com extensao
	 */
	public static function gerarNome($nome, $id) {
		$nome = html_entity_decode($nome);
		$nome = Util::formatarParaUrl($nome);
		return $nome . '-' . date('dmy') . '-' . $id;
	}
	
	public static function gerarId($pasta, $max_rec =  3) {
		global $_;
		if(!is_dir($pasta)){
			throw new InvalidArgumentException("Pasta invalida: " . $pasta);
		}
		$idUlt = 0;
		if($handle = opendir($pasta)){ 
		
			while (false !== ($arquivo = readdir($handle))) {
				if($arquivo != '.' && $arquivo != '..'){
					if(is_dir($pasta .$arquivo) && $max_rec > 0) {
						$val = ImagemFactory::gerarId($pasta . $arquivo, $max_rec - 1);
						$idUlt = $idUlt < $val ? $val : $idUlt;
					} else {
						$valor = explode('.', $arquivo);
						$valor = explode('-',$valor[0]);
						$idUlt = $idUlt < (int)$valor[count($valor)-1] ? (int)$valor[count($valor)-1] : $idUlt;
					}
				}
			}
			closedir($handle); 
		} else {
			throw new IOException("Erro ao tentar abrir a pasta: " . $pasta );
		}
		return $idUlt+1;
	}
	
	public static function renomear($antigo, $novo) {
		$pasta = dirname($novo);
		if($pasta != '' && !is_dir($pasta)) {
			mkdir($pasta, 0777, true);
		}
		return rename($antigo, $novo);
	}
	
	public static function redimensionar(&$imagem, $largura, $altura, $keepAspect = true, $alpha = true, $color = null) {
		$cur_largura = imagesx($imagem);
		$cur_altura = imagesy($imagem);

		if($cur_largura == 0 || $cur_altura == 0){
			throw new RuntimeException("Nao foi possivel ler o tamanho da imagem!");
		}
		
		if(isset($largura) && !isset($altura)) {
			$altura = intval(($largura/$cur_largura)*$altura);
		}
		
		if(isset($altura) && !isset($largura)) {
			$largura = intval(($altura/$cur_altura)*$largura);
		}
		
		if($largura == 0 || $altura == 0){
			throw new InvalidArgumentException("Altura e largura nao podem ser 0!");
		}
		
		$scale_x = $largura / $cur_largura;
		$scale_y = $altura / $cur_altura;
		$tx = 0;
		$ty = 0;
		if($keepAspect) {
			if ($altura >= $scale_x * $cur_altura) {
				$scale_y = $scale_x;
				$ty = intval(($altura - ($cur_altura * $scale_x)) / 2.);
			} else {
				$scale_x = $scale_y;
				$tx = intval(($largura - ($cur_largura * $scale_y)) /  2.);
			}
		}
		
		$nova = imagecreatetruecolor($largura, $altura);
		
		//Padrao branco
		$red = 255;
		$blue = 255;
		$green = 255;
			
		if(isset($color)) {
			if(isset($color['red']) && $color['red'] >= 0 && $color['red'] < 256) {
				$red = $color['red'];
			} else {
				$red = 0;
			}
			
			if(isset($color['blue']) && $color['blue'] >= 0 && $color['blue'] < 256) {
				$blue = $color['blue'];
			} else {
				$blue = 0;
			}
			
			if(isset($color['green']) && $color['green'] >= 0 && $color['green'] < 256) {
				$green = $color['green'];
			} else {
				$green = 0;
			}
		}
		
		if($alpha) {
			imagealphablending ($nova, true);
			$cor = imagecolorallocatealpha($nova, $red, $blue, $green, 127);
		} else {
			imagealphablending ($nova, false);
			$cor = imagecolorallocate($nova, $red, $blue, $green);
		}
		
		imagefill($nova, 0, 0, $cor);
		if( imagecopyresampled($nova, $imagem, $tx, $ty, 0, 0, $cur_largura * $scale_x, $cur_altura * $scale_y, $cur_largura, $cur_altura) ) {
			imagesavealpha($nova, true);
			return $nova;
		} else {
			throw new RuntimeException("Nao foi possivel redimensionar a imagem!");
		}
	}
	/*
	 * Cortar imagem, iniciando em x,y e com tamanho largura/altura
	 *
	 * @imagem - Imagem no formato resource do php
	 */
	public static function crop(&$imagem, $x, $y, $largura, $altura) {
		
		if($x < 0 || $y < 0 || $altura < 1 || $largura < 1) {
			throw new InvalidArgumentException("Esperava-se valores positivos para x,y, altura e largura, (" . $x . ", " . $y . ", " . $largura . ", " . $altura .")");
		}
	
		$cur_largura = imagesx($imagem);
		$cur_altura = imagesy($imagem);

		if($x + $largura > $cur_largura || $y + $altura > $cur_altura) {
			throw new InvalidArgumentException("(largura + x) e (altura + y) devem ser menores do que o tamanho da imagem original");
		}
		
		$nova = imagecreatetruecolor($largura, $altura);
		imagealphablending ($nova, true);
		$transparente = imagecolorallocatealpha($nova, 255, 255, 255, 127);
		imagefill($nova, 0, 0, $transparente);
		if( imagecopyresampled($nova, $imagem, 0, 0, $x, $y, $largura, $altura, $largura, $altura) ) {
			imagesavealpha($nova, true);
			return $nova;
		} else {
			throw new RuntimeException("Nao foi possivel redimensionar a imagem!");
		}
	}
	
	public static function aplicarFiltro($img, $filtro, $opts) {
	
		//trick para copiar a imagem
		$largura = imagesx($img);
		$altura = imagesy($img);
		$imagem = ImagemFactory::redimensionar($img, $largura, $altura);
		///////////////////////////////
		switch($filtro) {
			//check dos parametros red, green, blue, alpha
			case IMG_FILTER_COLORIZE:
				if(isset($opts['red']) && isset($opts['green']) && isset($opts['blue']) && isset($opts['alpha'])) {
					$status = imagefilter($imagem, $filtro, $opts['red'], $opts['green'], $opts['blue'], $opts['alpha']);
				} else {
					throw new InvalidArgumentException("Para usar o filtro colorize e necessario passar as opcoes 'red', 'green', 'blue' e 'alpha'");
				}
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro colorize na imagem");
				}
				break;
			case IMG_FILTER_BRIGHTNESS:
				if(isset($opts['brightness'])) {
					$status = imagefilter($imagem, $filtro, $opts['brightness']);
				} else {
					throw new invalidArgumentException("Para usar o filtro brightness e necessario passar a opcao 'brightness'");
				}
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro brightness na imagem");
				}
				break;
			case IMG_FILTER_CONTRAST:
				if(isset($opts['contrast'])) {
					$status = imagefilter($imagem, $filtro, $opts['contrast']);
				} else {
					throw new invalidArgumentException("Para usar o filtro contrast e necessario passar a opcao 'contrast'");
				}
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro contrast na imagem");
				}
				break;
			case IMG_FILTER_SMOOTH:
				if(isset($opts['smooth'])) {
					$status = imagefilter($imagem, $filtro, $opts['smooth']);
				} else {
					throw new invalidArgumentException("Para usar o filtro smooth e necessario passar a opcao 'smooth'");
				}
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro smooth na imagem");
				}
				break;
			case IMG_FILTER_PIXELATE:
				if(isset($opts['block'])) {
					$status = imagefilter($imagem, $filtro, $opts['block']);
				} else {
					throw new invalidArgumentException("Para usar o filtro pixelate e necessario passar a opcao 'block'");
				}
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro pixelate na imagem");
				}
				break;
			case IMG_FILTER_NEGATE:
			case IMG_FILTER_GRAYSCALE:
			case IMG_FILTER_EDGEDETECT:
			case IMG_FILTER_EMBOSS:
			case IMG_FILTER_GAUSSIAN_BLUR:
			case IMG_FILTER_SELECTIVE_BLUR:
			case IMG_FILTER_MEAN_REMOVAL:
				$status = imagefilter($imagem, $filtro);
				if($status) {
					return $imagem;
				} else {
					throw new RuntimeException("Nao foi possivel aplicar o filtro " . $filtro . " na imagem");
				}
				break;
			default:
				return $imagem;
		}
	}
	
	public static function base64Encode($filename) {
		$imgbinary = fread(fopen($filename, "r"), filesize($filename));
		$filetype = pathinfo($filename, PATHINFO_EXTENSION);
	    return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
	}
	
	
	//http://php.net/manual/pt_BR/function.imagecreatefromwbmp.php
	//alexander at alexauto dot nl
	 public function imagecreatefrombmp($p_sFile) 
    { 
        //    Load the image into a string 
        $file    =    fopen($p_sFile,"rb"); 
        $read    =    fread($file,10); 
        while(!feof($file)&&($read<>"")) 
            $read    .=    fread($file,1024); 
        
        $temp    =    unpack("H*",$read); 
        $hex    =    $temp[1]; 
        $header    =    substr($hex,0,108); 
        
        //    Process the header 
        //    Structure: http://www.fastgraph.com/help/bmp_header_format.html 
        if (substr($header,0,4)=="424d") 
        { 
            //    Cut it in parts of 2 bytes 
            $header_parts    =    str_split($header,2); 
            
            //    Get the width        4 bytes 
            $width            =    hexdec($header_parts[19].$header_parts[18]); 
            
            //    Get the height        4 bytes 
            $height            =    hexdec($header_parts[23].$header_parts[22]); 
            
            //    Unset the header params 
            unset($header_parts); 
        } 
        
        //    Define starting X and Y 
        $x                =    0; 
        $y                =    1; 
        
        //    Create newimage 
        $image            =    imagecreatetruecolor($width,$height); 
        
        //    Grab the body from the image 
        $body            =    substr($hex,108); 

        //    Calculate if padding at the end-line is needed 
        //    Divided by two to keep overview. 
        //    1 byte = 2 HEX-chars 
        $body_size        =    (strlen($body)/2); 
        $header_size    =    ($width*$height); 

        //    Use end-line padding? Only when needed 
        $usePadding        =    ($body_size>($header_size*3)+4); 
        
        //    Using a for-loop with index-calculation instaid of str_split to avoid large memory consumption 
        //    Calculate the next DWORD-position in the body 
        for ($i=0;$i<$body_size;$i+=3) 
        { 
            //    Calculate line-ending and padding 
            if ($x>=$width) 
            { 
                //    If padding needed, ignore image-padding 
                //    Shift i to the ending of the current 32-bit-block 
                if ($usePadding) 
                    $i    +=    $width%4; 
                
                //    Reset horizontal position 
                $x    =    0; 
                
                //    Raise the height-position (bottom-up) 
                $y++; 
                
                //    Reached the image-height? Break the for-loop 
                if ($y>$height) 
                    break; 
            } 
            
            //    Calculation of the RGB-pixel (defined as BGR in image-data) 
            //    Define $i_pos as absolute position in the body 
            $i_pos    =    $i*2; 
            $r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]); 
            $g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]); 
            $b        =    hexdec($body[$i_pos].$body[$i_pos+1]); 
            
            //    Calculate and draw the pixel 
            $color    =    imagecolorallocate($image,$r,$g,$b); 
            imagesetpixel($image,$x,$height-$y,$color); 
            
            //    Raise the horizontal position 
            $x++; 
        } 
        
        //    Unset the body / free the memory 
        unset($body); 
        
        //    Return image-object 
        return $image; 
    }
	
	public static function imagebmp($img, $caminho) {
		return file_put_contents($caminho, ImagemFactory::GD2BMPstring($img));
	}

	/*
		Codigos removidos de "PHP Image Magician", Open-source project
	*/
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*-*-*-*- 
  BMP SUPPORT (SAVING) - James Heinrich 
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*-*-*-*/   
  
  private function GD2BMPstring(&$gd_image)
    # Author:     James Heinrich
    # Purpose:    Save file as type bmp
    # Param in:   The image canvas (passed as ref)
    # Param out:
    # Reference:
    # Notes:    This code was stripped out of two external files  
  #       (phpthumb.bmp.php,phpthumb.functions.php) and added below to 
  #       avoid dependancies.
    #
  {
    $imageX = ImageSX($gd_image);
    $imageY = ImageSY($gd_image);

    $BMP = '';
    for ($y = ($imageY - 1); $y >= 0; $y--) {
      $thisline = '';
      for ($x = 0; $x < $imageX; $x++) {
        $argb = ImagemFactory::GetPixelColor($gd_image, $x, $y);
        $thisline .= chr($argb['blue']).chr($argb['green']).chr($argb['red']);
      }
      while (strlen($thisline) % 4) {
        $thisline .= "\x00";
      }
      $BMP .= $thisline;
    }

    $bmpSize = strlen($BMP) + 14 + 40;
    // BITMAPFILEHEADER [14 bytes] - http://msdn.microsoft.com/library/en-us/gdi/bitmaps_62uq.asp
    $BITMAPFILEHEADER  = 'BM';                                    // WORD    bfType;
    $BITMAPFILEHEADER .= ImagemFactory::LittleEndian2String($bmpSize, 4); // DWORD   bfSize;
    $BITMAPFILEHEADER .= ImagemFactory::LittleEndian2String(       0, 2); // WORD    bfReserved1;
    $BITMAPFILEHEADER .= ImagemFactory::LittleEndian2String(       0, 2); // WORD    bfReserved2;
    $BITMAPFILEHEADER .= ImagemFactory::LittleEndian2String(      54, 4); // DWORD   bfOffBits;

    // BITMAPINFOHEADER - [40 bytes] http://msdn.microsoft.com/library/en-us/gdi/bitmaps_1rw2.asp
    $BITMAPINFOHEADER  = ImagemFactory::LittleEndian2String(      40, 4); // DWORD  biSize;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String( $imageX, 4); // LONG   biWidth;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String( $imageY, 4); // LONG   biHeight;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(       1, 2); // WORD   biPlanes;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(      24, 2); // WORD   biBitCount;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(       0, 4); // DWORD  biCompression;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(       0, 4); // DWORD  biSizeImage;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(    2835, 4); // LONG   biXPelsPerMeter;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(    2835, 4); // LONG   biYPelsPerMeter;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(       0, 4); // DWORD  biClrUsed;
    $BITMAPINFOHEADER .= ImagemFactory::LittleEndian2String(       0, 4); // DWORD  biClrImportant;

    return $BITMAPFILEHEADER.$BITMAPINFOHEADER.$BMP;
  }
  
    private function LittleEndian2String($number, $minbytes=1)
    # Author:     James Heinrich    
    # Purpose:    BMP SUPPORT (SAVING)  
    # Param in:
    # Param out:
    # Reference:
    # Notes:
    #
  {
    $intstring = '';
    while ($number > 0) {
      $intstring = $intstring.chr($number & 255);
      $number >>= 8;
    }
    return str_pad($intstring, $minbytes, "\x00", STR_PAD_RIGHT);
  }
  
  private function GetPixelColor(&$img, $x, $y)
    # Author:     James Heinrich
    # Purpose:
    # Param in:
    # Param out:
    # Reference:
    # Notes:
    #
  {
    if (!is_resource($img)) {
      return false;
    }
    return @ImageColorsForIndex($img, @ImageColorAt($img, $x, $y));
  }
}
?>