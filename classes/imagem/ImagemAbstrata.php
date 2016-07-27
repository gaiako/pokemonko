<?php
abstract class ImagemAbstrata{

	public $id = 0;
	public $idObjeto = 0;
	public $nomeObjeto = "";
	public $pasta = "";
	public $imagem = "";
	public $principal = false;
	public $costas = false;
	public $ordem = null;
	public $extensao = "";

	/**
	 * Método que deve ser implementada por suas filhas,
	 * a garantir o caminho de exibição da imagem em questão,
	 * sedo no próprio servidor ou de terceiros.
	 * @param  string $subPasta nome da subpasta onde se encontra
	 * @return string
	 */
	public abstract function getCaminhoExibicao($subPasta = '');

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getIdObjeto(){
		return $this->idObjeto;
	}

	public function setIdObjeto($idObjeto){
		$this->idObjeto = $idObjeto;
	}

	/**
	 * Métodos para evitar possíveis conflitos,
	 * pois a ImagemAbstrata foi criada posteriormente
	 */
	public function getNome(){
		return $this->nomeObjeto;
	}

	public function setNome($nomeObjeto){
		$this->nomeObjeto = $nomeObjeto;
	}
	/**
	 * Fim métodos para evitar possíveis conflitos.
	 */

	public function getNomeObjeto(){
		return $this->nomeObjeto;
	}

	public function setNomeObjeto($nomeObjeto){
		$this->nomeObjeto = $nomeObjeto;
	}

	public function getPasta(){
		return $this->pasta;
	}

	public function setPasta($pasta){
		$this->pasta = $pasta;
	}

	public function getImagem(){
		return $this->imagem;
	}

	public function setImagem($imagem){
		$this->imagem = $imagem;
	}

	public function getPrincipal(){
		return $this->principal;
	}

	public function setPrincipal($principal = true){
		$this->principal = $principal;
	}

	public function getCostas(){
		return $this->costas;
	}

	public function setCostas($costas = true){
		$this->costas = $costas;
	}

	public function getOrdem(){
		return $this->ordem;
	}

	public function setOrdem($ordem = true){
		$this->ordem = $ordem;
	}

	public function getExtensao() {
		return $this->extensao;
	}

	public function setExtensao($extensao){
		$this->extensao = $extensao;
	}

	public function getLargura() {
		return imagesx($this->imagem);
	}

	public function getAltura() {
		return imagesy($this->imagem);
	}

	public function getCaminhoIndividual($subPasta = ''){
		if($subPasta != '')
			$subPasta = $subPasta.'/';
		return $this->pasta . $subPasta . $this->imagem;
	}

	/**
	* Transforma a classe em string
	*
	* @author Douglas
	*
	* @name __toString
	* @example echo "A foto $foto é ótima";
	* @return string
	*	Caminho de exibição da foto
	*/
	public function __toString(){
		return $this->getCaminhoExibicao();
	}

}