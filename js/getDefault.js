function get(callback, target, operation, params, debugMode){
	var dataType = 'json';
	var isDebugMode = (debugMode != undefined && debugMode === true);
	
	if(params == undefined) params = {};
	if(isDebugMode === true){
		dataType = 'text';
	}

	var notParam = {};
	if(params.notParam != undefined){
		notParam = params.notParam;
		delete params.notParam;
	}
	
	var data = {
		get : { 
			t : target,
			o : operation,
			p : params
		}
	}

	if(notParam != {}){
		for(var key in notParam){
			data[key] = notParam[key];
		}
	}
	
	$.ajax({
		url: RAIZ+'/php/get.php', 
		data: data,
		dataType: dataType, 
		success: function(result) {
			if(isDebugMode === true){
				console.log(result);
			}else{
				if(result.success == true){
					callback(result.data);
				}else{
					alert(result.message);
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			console.log("Houve um erro na execução do get: ");
			console.log(jqXHR);
		}
	});
};