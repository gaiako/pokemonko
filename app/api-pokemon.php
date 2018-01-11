<?php
$pokemonBaseController = Util::makeController('pokemonBase');
$bancoDados = new BancoDados();

$comando = "select id,nome from pokemonbase";
$pokemons = $bancoDados->consultar($comando);

foreach($pokemons as $pokemon){
	$nome = strtolower($pokemon['nome']);
	$id = str_pad($pokemon['id'],3,'0',STR_PAD_LEFT);

	$ch = curl_init('http://www.pokestadium.com/sprites/black-white/'.$nome.'.png');
	$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/app/assets/images/pokemon/sprite/'.$id.'.png', 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);

	// ---

	$ch = curl_init('http://www.pokestadium.com/sprites/black-white/back/'.$nome.'.png');
	$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/app/assets/images/pokemon/sprite/'.$id.'-back.png', 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);

	// ---

	$ch = curl_init('http://www.pokestadium.com/sprites/black-white/shiny/'.$nome.'.png');
	$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/app/assets/images/pokemon/sprite/'.$id.'-shiny.png', 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);

	// ---

	$ch = curl_init('http://www.pokestadium.com/sprites/black-white/shiny/back/'.$nome.'.png');
	$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/app/assets/images/pokemon/sprite/'.$id.'-shiny-back.png', 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}

/*
for($i=1;$i<252;$i++){
	$json = file_get_contents('http://pokeapi.co/api/v1/pokemon/'.$i.'/');

	$pokemon = json_decode($json);

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
		'dragon' => '15',
		'dark' => '16',
		'steel' => '17',
		'fairy' => '18'
	);
	$tipo1 = $pokemon->types[0]->name;
	$tipo1 = $types[$tipo1];
	$tipo2 = $pokemon->types[1]->name;
	if(is_string($tipo2))
		$tipo2 = $types[$tipo2];

	$comando = "
	insert into pokemonbase (id,nome,hp,ataque,defesa,velocidade,ataqueEspecial,defesaEspecial,idTipo,idTipo2,exp,sortePokeball) values (:id,:nome,:hp,:ataque,:defesa,:velocidade,:ataqueEspecial,:defesaEspecial,:tipo1,:tipo2,:exp,:sortePokeball)
	";
	$parametros = array(
		'id' => $i,
		'nome' => $pokemon->name,
		'hp' => $pokemon->hp,
		'ataque' => $pokemon->attack,
		'defesa' => $pokemon->defense,
		'velocidade' => $pokemon->speed,
		'tipo1' => $tipo1,
		'tipo2' => is_string($tipo2) ? $tipo2 : null,
		'ataqueEspecial' => $pokemon->sp_atk,
		'defesaEspecial' => $pokemon->sp_def,
		'exp' => $pokemon->exp,
		'sortePokeball' => $pokemon->catch_rate
	);
	$bancoDados->executar($comando,$parametros);
	
	foreach($pokemon->moves as $move){
		$explode = explode('/',$move->resource_uri);
		
		$id = $explode[count($explode)-2];
		
		if(!is_numeric($id))
			die('burro');
		if($id <= 251){
			
			$comando = "insert into pokemonbase_ataque (idPokemonBase,idAtaque,tipoAprendizado,nivel) values (:idPokemonBase,:idAtaque,:tipoAprendizado,:nivel)";
			$parametros = array(
				'idPokemonBase' => $i,
				'idAtaque' => $id,
				'tipoAprendizado' => $move->learn_type,
				'nivel' => (isset($move->level)) ? $move->level : null
			);
			$bancoDados->executar($comando,$parametros);
		}
	}
	
	foreach($pokemon->evolutions as $evolution){
		$comando = "select id from pokemonbase where nome = '".$evolution->to."'";
		$l = $bancoDados->consultar($comando);
		if(count($l)){
			$idEvolucao = $l[0]['id'];
			$comando = "insert into evolucao (idPokemon,idEvolucao,nivelNecessario,itemNecessario) values (:idPokemon,:idEvolucao,:nivelNecessario,:itemNecessario)";
			$parametros = array(
				'idPokemon' => $i,
				'idEvolucao' => $idEvolucao,
				'nivelNecessario' => (isset($evolution->level)) ? $evolution->level : null,
				'itemNecessario' => $evolution->method
			);
			$bancoDados->executar($comando,$parametros);
		}
	}
}

$comando = "select id from ataque";
$l = $bancoDados->consultar($comando);
*/

/*for($i=1;$i<252;$i++){
	$json = file_get_contents('http://pokeapi.co/api/v2/move/'.$i.'/');

	$move = json_decode($json);
	
	
	
	$comando = "insert into ataque (id,nome,descricao,categoria,tipo,dano,precisao,precisaoEfeito,prioridade,category,healing,drain,ailment,stat_chance,flinch_chance,crit_rate,min_hits,max_hits,min_turns,max_turns) values (:id,:nome,:descricao,:categoria,:tipo,:dano,:precisao,:precisaoEfeito,:prioridade,:category,:healing,:drain,:ailment,:stat_chance,:flinch_chance,:crit_rate,:min_hits,:max_hits,:min_turns,:max_turns)";
	
	$parametros = array(
		'id' => $i,
		'nome' => $move->names[0]->name,
		'descricao' => $move->effect_entries['0']->effect,
		'categoria' => $move->damage_class->name,
		'tipo' => $types[$move->type->name],
		'dano' => $move->power,
		'precisao' => $move->accuracy,
		'precisaoEfeito' => $move->effect_chance == null ? '' : $move->effect_chance,
		'prioridade' => $move->priority,
		'category' => $move->meta->category->name,
		'healing' => $move->meta->healing,
		'drain' => $move->meta->drain,
		'ailment' => $move->meta->ailment->name,
		'stat_chance' => $move->meta->stat_chance,
		'flinch_chance' => $move->meta->flinch_chance,
		'crit_rate' => $move->meta->crit_rate,
		'min_hits' => $move->meta->min_hits,
		'max_hits' => $move->meta->max_hits,
		'min_turns' => $move->meta->min_turns,
		'max_turns' => $move->meta->max_turns
	);
	$bancoDados->executar($comando,$parametros);
}*/
?>