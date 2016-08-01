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

$(document).keydown(function(event){
	event.preventDefault();
	
	//Mover personagem
	if(event.keyCode >= 37 && event.keyCode <= 40 && anda == true){
		tecla = event.keyCode;
		
		if($('.personagem.ativo').hasClass('looking-'+looking[tecla])){
			
		}else{
			$('.personagem.ativo').removeClassPrefix('looking-');
			$('.personagem.ativo').addClass('looking-'+looking[tecla]);
			$('.personagem.ativo').attr('data-looking','looking-'+looking[tecla]);
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
				$('div.personagem.ativo').animate({'top' : posicao.top+'px','left' : posicao.left+'px'},400,function(){ anda = true; });
			}else{
				x = xAntes;
				y = yAntes;
			}
		}
	}
});