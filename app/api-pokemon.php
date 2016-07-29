<?php
$pokemonBaseController = Util::makeController('pokemonBase');
$bancoDados = new BancoDados();


//$json = file_get_contents('http://pokeapi.co/api/v2/move/1/');
//$move = json_decode($json);
//echo $move->effect_entries['0']->effect; exit;
//echo '<pre>';
//print_r($move); exit;
//echo '</pre>';
//exit;

/*
$pokemonBase = $pokemonBaseController->obterTodos();
foreach($pokemonBase as $k => $pb){
	//if($k <= 10)
		//break;
	
	$json = file_get_contents('http://pokeapi.co/api/v1/pokemon/'.$pb->getId().'/');
	
	$pokemon = json_decode($json);
	
	$comando = "
	update pokemon_base set 
	hp = :hp,
	ataque = :ataque,
	defesa = :defesa,
	agilidade = :agilidade,
	ataqueEspecial = :ataqueEspecial,
	defesaEspecial = :defesaEspecial,
	alegria = :alegria,
	exp = :exp,
	sortePokeball = :sortePokeball,
	taxaCrescimento = :taxaCrescimento 
	where id = :id
	";
	$parametros = array(
		'hp' => $pokemon->hp,
		'ataque' => $pokemon->attack,
		'defesa' => $pokemon->defense,
		'agilidade' => $pokemon->speed,
		'ataqueEspecial' => $pokemon->sp_atk,
		'defesaEspecial' => $pokemon->sp_def,
		'alegria' => $pokemon->happiness,
		'exp' => $pokemon->exp,
		'sortePokeball' => $pokemon->catch_rate,
		'taxaCrescimento' => $pokemon->growth_rate,
		'id' => $pb->getId()
	);
	$bancoDados->executar($comando,$parametros);
	
	foreach($pokemon->moves as $move){
		$explode = explode('/',$move->resource_uri);
		
		$id = $explode[count($explode)-2];
		
		if(!is_numeric($id))
			die('burro');
		if($id <= 165){
			$comando = "select id from ataque where id = '".$id."'";
			$l = $bancoDados->consultar($comando);
			
			if(!count($l)){
				$comando = 'insert into ataque (id,nome) values ('.$id.',"'.$move->name.'")';
				$bancoDados->executar($comando);
				$idAtaque = $bancoDados->ultimoId();
			}else{
				$idAtaque = $l[0]['id'];
			}
			
			$comando = "insert into pokemon_ataque (idPokemonBase,idAtaque,tipoAprendizado,nivel) values (:idPokemonBase,:idAtaque,:tipoAprendizado,:nivel)";
			$parametros = array(
				'idPokemonBase' => $pb->getId(),
				'idAtaque' => $idAtaque,
				'tipoAprendizado' => $move->learn_type,
				'nivel' => (isset($move->level)) ? $move->level : null
			);
			$bancoDados->executar($comando,$parametros);
		}
	}
	
	foreach($pokemon->evolutions as $evolution){
		$comando = "select id from pokemon_base where nome = '".$evolution->to."'";
		$l = $bancoDados->consultar($comando);
		if(count($l)){
			$idEvolucao = $l[0]['id'];
			$comando = "insert into evolucao (idPokemon,idEvolucao,nivelNecessario,itemNecessario) values (:idPokemon,:idEvolucao,:nivelNecessario,:itemNecessario)";
			$parametros = array(
				'idPokemon' => $pb->getId(),
				'idEvolucao' => $idEvolucao,
				'nivelNecessario' => (isset($evolution->level)) ? $evolution->level : null,
				'itemNecessario' => $evolution->method
			);
			$bancoDados->executar($comando,$parametros);
		}
	}
}
*/

$comando = "select id from ataque";
$l = $bancoDados->consultar($comando);

foreach($l as $ataque){
	$json = file_get_contents('http://pokeapi.co/api/v2/move/'.$ataque['id'].'/');
	
	/*$json = file_get_contents('http://pokeapi.co/api/v2/move/1/');
	$move = json_decode($json);
	echo '<pre>';
	print_r($move); exit;
	echo '</pre>';
	exit;*/
	
	/*$move = json_decode($json);
	
	$types = array(
		'normal' => '1',
		'fighting' => '2',
		'flying' => '3',
		'poison' => '4',
		'ground' => '5',
		'rock' => '6',
		'bug' => '7',
		'ghost' => '8',
		'fire' => '9',
		'water' => '10',
		'grass' => '11',
		'electric' => '12',
		'psychic' => '13',
		'ice' => '14',
		'dragon' => '15'
	);
	
	$comando = "update ataque set 
	descricao = :descricao,
	categoria = :categoria,
	tipo = :tipo,
	dano = :dano,
	precisao = :precisao,
	precisaoEfeito = :precisaoEfeito,
	prioridade = :prioridade 
	where id = :id
	";
	
		$parametros = array(
			'descricao' => $move->effect_entries['0']->effect,
			'categoria' => $move->damage_class->name,
			'tipo' => $types[$move->type->name],
			'dano' => $move->power,
			'precisao' => $move->accuracy,
			'precisaoEfeito' => $move->effect_chance,
			'prioridade' => $move->priority,
			'id' => $ataque['id']
		);
		$bancoDados->executar($comando,$parametros);
}*/
?>