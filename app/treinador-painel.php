<?php
$treinadorController = new TreinadorController();
$pokemonController = new PokemonController();
$ataqueController = new AtaqueController();
$treinador = $treinadorController->obterTreinadorDaVez();
$pokemons = $pokemonController->obterComRestricoes(array('idTreinadorGravacao'=>$treinador->getId()),'ordem desc');
?>

<style>
.treinador-sprite{
	position: relative;
	float:left;
	width: 32px;
	height: 32px;
	background-image: url('<?php echo $config->pastaImagemSprite.$treinador->getSprite(); ?>.png');
}

.treinador-nome{
	position: relative;
	float: left;
	height: 32px;
	text-align: center;
	vertical-align: middle;
	line-height: 32px;
}

div.gif-pokemon{
	position: relative;
	width: 120px;
	height: 120px;
	background-color: #333;
	border-top: 2px solid #F00;
	background-position: center;
	background-repeat: no-repeat;
	
	-webkit-border-radius: 60px;
}

table.painel{
	font-family: monospace;
	background-color: #DDD;
	height: 100%;
	table-layout:fixed;
	border-radius: 5px;
	width: 1000px;
}

table.pokemon{
	background-color: #CCC;
	margin: 5px;
	border-radius: 3px;
	width: 475px;
}

td.nome-pokemon{
	font-weight: bold;
}

td.stats{
	padding-left: 5px;
}

div.overflow{
	position: relative;
	max-height: 100vh;
	overflow-y: auto;
}

div.habilidade span{
	width:100px;
	border-radius: 9px;
	cursor: pointer;
	line-height: 20px;
	margin-bottom: 5px;
}
</style>

<div class="container">
	<table class="painel" align="center">
		<tr>
			<td colspan="2">
				<h3><div class="treinador-sprite"></div>
				<div class="treinador-nome">
					<?php echo $treinador->getNome(); ?> - <?php echo count($pokemons); ?> pokémons - <a href="/jogar">Voltar ao jogo</a>
				</div></h3>
			</td>
		</tr>
		<tr>
			<td>
				<div class="overflow" id="overflow">
				<?php
				foreach($pokemons as $pokemon){
					$pb = $pokemon->getPokemonBase();
					$ataquesDisponiveis = $ataqueController->obterOutrosAtaques($pokemon);
					?>
					<table class="pokemon">
						<tr>
							<td width="120">
								<table>
									<tr>
										<td align="center" class="nome-pokemon"><?php echo $pb->getNome().' - '.$pokemon->getId(); ?></td>
									</tr>
									<tr>
										<td width="120">
											<div class="gif-pokemon" style="background-image: url('<?php echo $config->pastaImagemPokemon.'gif/'.strtolower($pb->getNome()).'.gif'; ?>')">
										</td>
									</tr>
									<tr>
										<td align="center">
											<div class="tipos">
												<span id="tipo1" class="label" style="background-color: <?php echo $pb->getTipo()->getCor(); ?>"><?php echo $pb->getTipo()->getNome(); ?></span>
												<?php
												if($pb->getTipo2() instanceOf Tipo){
													?>
													<span id="tipo2" class="label" style="background-color: <?php echo $pb->getTipo2()->getCor(); ?>"><?php echo $pb->getTipo2()->getNome(); ?></span>
													<?php
												}
												?>
											</div>
										</td>
									</tr>
								</table>
							</td>
							<td class="stats">
								<div class="nivel">Nível <span id="nivel"><?php echo $pokemon->getNivel(); ?></span></div>
								<div class="hp">HP: <span id="hp"><?php echo $pokemon->getHp(); ?></span></div>
								<div class="ataque">Ataque: <span id="ataque"><?php echo $pokemon->getAtaque(); ?></span></div>
								<div class="defesa">Defesa: <span id="defesa"><?php echo $pokemon->getDefesa(); ?></span></div>
								<div class="ataqueEspecial">Atq. Especial: <span id="ataqueEspecial"><?php echo $pokemon->getAtaqueEspecial(); ?></span></div>
								<div class="defesaEspecial">Def. Especial: <span id="defesaEspecial"><?php echo $pokemon->getDefesaEspecial(); ?></span></div>
								<div class="velocidade">Velocidade: <span id="velocidade"><?php echo $pokemon->getVelocidade(); ?></span></div>
							</td>
							<td align="center">
								<div class="moves">Habillidades</span>
									<?php
									foreach($pokemon->getAtaques() as $ataque){
										?>
										<div class="habilidade"><span class="label ataque" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $ataque->getDescricao(); ?>" style="background-color: <?php echo $ataque->getTipo()->getCor(); ?>;"><?php echo $ataque->getNome(); ?></span></div>
										<?php
									}
									?>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<?php
								foreach($ataquesDisponiveis as $atq){
									?>
									<div class="habilidade"><span class="label ataque" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $atq->getDescricao(); ?>" style="background-color: <?php echo $atq->getTipo()->getCor(); ?>;"><?php echo $atq->getNome(); ?></span></div>
									<?php
								}
								?>
							</td>
						</tr>
					</table>
					<?php
				}
				?>
				</div>
			</td>
			<td>
				
			</td>
		</tr>
	</table>
	
</div>

<script>
	$(document).ready(function(){ //88		
		$('.ataque').tooltip();
	});
</script>