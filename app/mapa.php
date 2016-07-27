<?php //print_r($mapa); exit; ?>
<style>
.mapa{
	width: <?php echo $mapa->getDimensaoX()*30; ?>px;
}
</style>

<div class="mapa">
<?php
$y = 0;
foreach($mapaPixels as $mp){
	if($mp['y'] != $y) echo '';
	if($mp['nomeTerreno'] != '') $style = "background-image: url('".$_->config->pastaImagemTerreno.Util::formatarParaUrl($mp['nomeTerreno']).".png')"; else $style = "background-color: ".$mp['cor'];
	?>
	<div class="mapa-pixel" data-idMapaPixel="<?php echo $mp['id']; ?>" data-x="<?php echo $mp['x']; ?>" data-y="<?php echo $mp['y']; ?>" data-possivelCaminhar="<?php echo $mp['possivelCaminhar']; ?>" style="<?php echo $style; ?>"><?php if($mp['nomeObjeto'] != '') echo '<img class="objeto" src="'.$_->config->pastaImagemObjeto.Util::formatarParaUrl($mp['nomeObjeto']).'.png" />'; ?></div>
	<?php
	if($mapa->getDimensaoY() == $y){
		echo '</div><div class="mapa">';
		$y = 0;
	}
	$i++;
}
?>
</div>