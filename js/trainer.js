var looking = {
	37 : 'left',
	38 : 'up',
	39 : 'right',
	40 : 'down'
}

$.fn.removeClassPrefix = function(prefix) {
    this.each(function(i, el) {
        var classes = el.className.split(" ").filter(function(c) {
            return c.lastIndexOf(prefix, 0) !== 0;
        });
        el.className = $.trim(classes.join(" "));
    });
    return this;
};

function delDivs(divs){
	for(i=0;i<divs.length;i++){
		var delDiv = $('#pokemons').find('div.pokemon[data-idPokemon="'+divs[i]+'"]').fadeOut('slow').remove();
		//var delDiv = $('#pokemons').find('div:first').fadeOut('slow').remove();
	}
}

$(document).keydown(function(event){
	event.preventDefault();
	
	tecla = event.keyCode;
	
	//Mover personagem
	if(event.keyCode >= 37 && event.keyCode <= 40 && anda == true){
		
		if($('.personagem.ativo').hasClass('looking-'+looking[tecla])){
			
		}else{
			$('.personagem.ativo').removeClassPrefix('looking-');
			$('.personagem.ativo').addClass('looking-'+looking[tecla]);
			$('.personagem.ativo').attr('data-looking',looking[tecla]);
			return false;
		}
		
		enviaPost = true;
		bloqueado = parseInt($('div[data-x="'+x+'"][data-y="'+y+'"]').attr('data-bloqueado'));
		
		if(tecla == bloqueado)
			return false;
		
		xAntes = x;
		yAntes = y;
		if(tecla == 39)
			x = x+1;
		if(tecla == 37)
			x = x-1;
		if(tecla == 38)
			y = y-1;
		if(tecla == 40)
			y = y+1;
		
		if(x == 0){
			x = 1;
			enviaPost = false;
		}
		if(y == 0){
			y = 1;
			enviaPost = false;
		}
		
		if(enviaPost == true){
			if($('div[data-x="'+x+'"][data-y="'+y+'"]').attr('data-possivelCaminhar') == 1){
				posicao = $('div[data-x="'+x+'"][data-y="'+y+'"]').position();
			
				var data = {
					act : {
						t : 'TreinadorController',
						o : 'mover',
						p : {
							x : x,
							y : y,
							looking : looking[tecla]
						}
					}
				}
				
				$.post('/php/act.php',data,function(result){
					if(result.success == true && result.message != null){
						
					}
				},'json');
				anda = false;
				if($('div[data-x="'+x+'"][data-y="'+y+'"]').attr('data-water') == '1'){
					$('div.personagem.ativo').addClass('water');
				}else{
					$('div.personagem.ativo').removeClass('water');
					$('div.personagem.ativo').addClass('animated');
				}
				$('div.personagem.ativo').animate({'top' : posicao.top+'px','left' : posicao.left+'px'},400,'linear',function(){ anda = true; $('div.personagem.ativo').removeClass('animated'); });
			}else{
				x = xAntes;
				y = yAntes;
			}
		}
	}
	
	//Capturar pokémon
	if(tecla == 32){
		
		var data = {
			act : {
				t : 'PokemonController',
				o : 'capturar',
				p : {
					looking : $('.personagem.ativo').attr('data-looking')
				}
			}
		}
		
		$.post('/php/act.php',data,function(result){
			if(result.message.pokemon != null){
				var pokemon = result.message.pokemon;
				$('.gif-pokemon-capturado').css('background-image','url("'+raiz+'app/assets/images/pokemon/gif/'+result.message.pokemon.pokemonBase.nome.toLowerCase()+'.gif")');
				$('#nome-pokemon-capturado').html(pokemon.pokemonBase.nome);
				console.log(pokemon.pokemonBase.tipo.nome);
				$('#tipo1').html(pokemon.pokemonBase.tipo.nome).css('background-color',pokemon.pokemonBase.tipo.cor);
				if(pokemon.pokemonBase.tipo2 != null)
					$('#tipo2').html(pokemon.pokemonBase.tipo2.nome).css('background-color',pokemon.pokemonBase.tipo2.cor);
				else
					$('#tipo2').html('');
				$('#nivel').html(pokemon.nivel);
				$('#hp').html(pokemon.hp);
				$('#ataque').html(pokemon.ataque);
				$('#defesa').html(pokemon.defesa);
				$('#ataqueEspecial').html(pokemon.ataqueEspecial);
				$('#defesaEspecial').html(pokemon.defesaEspecial);
				$('#velocidade').html(pokemon.velocidade);
				$('.pokemon-capturado').removeClass('escondido');
				//$.notify(result.message.pokemon.pokemonBase.nome+' capturado!', "success");
				delDivs(result.message.del);
			}else if(result.message.del == null){
				$.notify('Pokémon não capturado!', "alert");
			}else{
				$.notify('Pokémon não capturado fugiu!', "error");
				delDivs(result.message.del);
			}
		},'json');
	}
});