<?php //print_r($mapa); exit; ?>
<style>
.mapa{
	width: <?php echo $mapa->getDimensaoX()*32; ?>px;
}
</style>

<div class="mapa">
<?php
$y = 0;
foreach($mapaPixels as $mp){
	if($mp['y'] != $y) echo '';
	$style = '';
	if($mp['terreno'] != '') $style .= "background-image:";
	if($editor == true && !$mp['possivelCaminhar'])	$style .= "url('/app/assets/images/nPossivelCaminhar.png'),";
	if($editor == true && is_numeric($mp['idGrupo'])) $style .= "url('/app/assets/images/nAparecePokemon.png'),";
	if($mp['terreno'] != '') $style .= "url('".$config->pastaImagemTerreno.$mp['terreno']."')";
	?>
	<div class="mapa-pixel" 
	data-idMapaPixel="<?php echo $mp['id']; ?>" 
	data-x="<?php echo $mp['x']; ?>" 
	data-y="<?php echo $mp['y']; ?>" 
	data-possivelCaminhar="<?php echo $mp['possivelCaminhar']; ?>" 
	data-bloqueado="<?php echo $mp['bloqueado']; ?>" 
	data-water="<?php if($mp['terreno'] == 'water.png') echo '1'; else echo '0'; ?>" 
	style="<?php echo $style; ?>"><?php if($mp['objeto'] != '') echo '<img class="objeto" src="'.$config->pastaImagemObjeto.$mp['objeto'].'" />'; ?></div>
	<?php
	if($mapa->getDimensaoY() == $y){
		echo '</div><div class="mapa">';
		$y = 0;
	}
	$i++;
}
?>
</div>