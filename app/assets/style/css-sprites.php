<?php header("Content-type: text/css"); ?>

div.personagem{
	position: relative;
	width: 32px;
	height: 32px;
	background-repeat: no-repeat;
	margin-bottom:-30px;
	z-index:1000;
}

<?php
$gravacaoController = Util::makeController('gravacao');
$gravacao = $gravacaoController->obterComId($_SESSION['gravacao'],true);
foreach($gravacao->getTreinadores() as $k => $t){
	?>
	div.looking-down<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-down.png'; ?>');
	}div.looking-down<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-down;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-up<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-up.png'; ?>');
	}div.looking-up<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-up;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-right<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-right.png'; ?>');
	}div.looking-right<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-right;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-left<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-left.png'; ?>');
	}div.looking-left<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-left;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}
	<?php
}
?>

@keyframes personagemAnimacao-down {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-down-f1.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-down-f2.png'); }
}

@keyframes personagemAnimacao-up {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-up-f1.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-up-f2.png'); }
}

@keyframes personagemAnimacao-left {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-left-f1.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-left-f2.png'); }
}

@keyframes personagemAnimacao-right {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-right-f1.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$personagem->getSprite() ?>-right-f2.png'); }
}

div.pokemon{
	position: relative;
	width: 32px;
	height: 32px;
	margin-bottom:-32px;
	z-index:1000;
}