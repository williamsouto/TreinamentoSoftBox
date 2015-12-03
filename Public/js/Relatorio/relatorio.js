/**
 * 
 */

$('.btn-pesquisar').click(function() {
	
	$.post('http://localhost/TreinamentoSoftbox/relatorio/relatorio', {
		tipo: $('#drpTipo').val()
	}, function(data){
		
		var categoria = '';
		var html = '';
		var conteudo = '';
		var headTable = "<div class=\"panel panel-inverse\">" + 
							"<div class=\"panel-heading\">";
		
		var endHeadTable = "<a href=\"#\" data-toggle=\"collapse\" aria-expanded=\"false\"" +
								"aria-controls=\"collapseExample\"><i \"class=\"fa fa-angle-double-up pull-right\"></i></a>" +
						"</div>";
		
		var table = " <div class=\"panel-body\" class=\"collapse\" id=\"collapseExample\">" +
						"<div class=\"row\">" +
							"<div class=\"col-lg-12\">" +
								"<table class=\"table table-bordered\">" +
									"<thead>" +
										"<tr>" +
											"<th>Tipo</th>" +
											"<th>Valor</th>" +
											"<th>Data</th>" +
											"<th>Descri&ccedil;&atilde;o</th>" +
										"</tr>" +
									"</thead>" +
									"<tbody id='lancamentos'>";
		
		var endTable = "</tbody>" + "</table>" + "</div>" +	"</div>" + "</div>" + "</div>";
		
		if (data == 0) {
		
			var mensagem = 'Não foi possível gerar relatório, pois não à registros na base de dados.';
			
			$('#msgSuccess').html('<div class="alert alert-info alert-dismissible" role="alert">' +
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
							'<span aria-hidden="true">&times;</span>' +
					'</button>' +
					'<span class="content-msg">' + mensagem + '</span>' +
			  '</div>');
			
			$('#msgSuccess').show();
			
			html += headTable + 'Categoria' + endHeadTable + table + conteudo + endTable;
			
			$('#relatorio').html(html);
			
		} else {
			
			var title = '';
			
			$.each(data, function(key, value) {
				
				for (var i = 0; i < data[key].length; i++) {
					
					conteudo += "<tr>" +
					 				"<td>" + ((data[key][i].TIPO == "D") ? "Despesa" : "Receita") + "</td>" +
					 				"<td>" + data[key][i].VALOR + "</td>" +
					 				"<td>" + data[key][i].DT_LANC + "</td>" +
					 				"<td>" + data[key][i].DESCRICAO + "</td>" +
					 			"</tr>";
					title = data[key][i].NOME;
				}
				
				html += headTable + title + endHeadTable + table + conteudo + endTable;
				
				conteudo = '';
				
			});
			
			$('#relatorio').html(html);
		}
		
	}, 'json');
	
	return false;
	
});