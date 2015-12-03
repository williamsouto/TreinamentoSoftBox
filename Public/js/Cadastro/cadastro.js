/**
 * Arquivo responsável pela manipulação e animação da view cadastro.phtml
 * 
 */

// Eventos

// Função que seta os valores da grid Categoria, no formulário Cadastro de categoria.

$('.btnEditarCategoria').click(function() {
	btnEditarCategoria(this);
});


$('#cadastroCategoria').submit(function() {
	
	var id = $('#hdCodCategoria').val();
	var op = $('#hdOperacao').val();
	var url;
	
	if (op == "Novo") {
		url = 'http://localhost/TreinamentoSoftbox/cadastro/adicionar';
	} else {
		url = 'http://localhost/TreinamentoSoftbox/cadastro/editar/' + id;
	}
	
	$.post(url,{
		
		func : 'load',
		operacao: $('#hdOperacao').val(),
		idCategoria: id,
		nome: $('#txtNomeCategoria').val()
		
	}, function(data) {
		
		var classe;
		var linhaAnterior = '#' + $('#hdCodCategoria').prev().val();
		var linhaCorrente = '#' + $('#hdCodCategoria').val();
		var mensagem;
		var body = "<button id=" + data['idCategoria'] + " type=\"button\" class=\"list-group-item btnEditarCategoria\">" + data['nome'] + "</button>";
		
		// Verifica se a inserção, foi de um registro novo ou não, para construir a grid dinâmicamente. 
		if ($('#hdOperacao').val() == 'Editar') {
			mensagem = 'Registro n° ' + '<strong>' + data['idCategoria'] + '</strong> foi alterado com <strong>sucesso</strong>!';
			
			$(linhaCorrente).parent().html(body);
			
		} else {
			mensagem = 'O seu registro foi salvo com <strong>sucesso</strong>!<br>' +
			   			'N° registro - ' + '<strong>' + data['idCategoria'] + '</strong> gerado.';

			$('.categorias').append("<div class=\"item-categoria\">" + body + "<div class=\"item-categoria\"></div>");
		}
		
		$('#msgSuccess').html('<div class="alert alert-success alert-dismissible" role="alert">' +
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
											'<span aria-hidden="true">&times;</span>' +
									'</button>' +
									'<span class="content-msg">' + mensagem + '</span>' +
							  '</div>');
		
		$('#msgSuccess').show();
		
		limpaCamposCategoria();
		
		$('.btnEditarCategoria').click(function() {
			btnEditarCategoria(this);
		});
		
	}, 'json');
	
	return false;
	
});

$('.btnExcluirCategoria').click(function() {
	
	$.post("http://localhost/TreinamentoSoftbox/cadastro/excluir", {
		idCategoria: $('#hdCodCategoria').val()
	}, function(data) {
		
		var linhaCorrente = '#' + $('#hdCodCategoria').val();
		$(linhaCorrente).parent().remove();
		
		limpaCamposCategoria();
		
		$('.btnEditarCategoria').click(function() {
			btnEditarCategoria(this);
		});
	});
	
	return false;
});

// END Eventos


// Métodos

function limpaCamposCategoria() {
	$('#hdOperacao').val('Novo');
	$('#hdCodCategoria').val('');
	$('#txtNomeCategoria').val('');
}

function btnEditarCategoria(e) {
	
	var id = $(e).attr('id');
	var categoria = $(e).html();
	
	$('#hdOperacao').val('Editar');
	$('#hdCodCategoria').val(id);
	$('#txtNomeCategoria').val(categoria);
}

