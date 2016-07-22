$(document).ready(function(){
	if($('.nav-meu-menu ul .nav-header').length >= 8){
		$('.nav-meu-menu ul li').hide();
		$('.nav-meu-menu ul .nav-header').show();
		$('.active').parent().find('li').show();
		
		$('.nav-meu-menu ul .nav-header').prepend('(<span class="status-menu-header">+</span>) ');
		
		$('.active').parent().find('.status-menu-header').text('-');
		
		$('.nav-meu-menu ul .nav-header').click(function(){
			$(this).parent().find('li:gt(0)').toggle('fast');
			if( $(this).parent().find('.status-menu-header').text() == '-' ){
				$(this).parent().find('.status-menu-header').text('+');
			}else $(this).parent().find('.status-menu-header').text('-');
		});
	}
});