/**
 * 
 */

var idRegistro;

$(document).ready(function() {
	$("#txtValor").maskMoney();
	jQuery("#dtLancamento").mask("99/99/9999");
}); 

// Eventos

$('.btnEditar').click(function() {
	btnEditar(this);
});

$('.btnExcluir').click(function() {
	idRegistro = $(this).attr('id');
	$(this).attr('data-toggle','modal');
});

$('#btnMdlCancelar').click(function() {
	idRegistro = null;
});

$('#btnMdlExcluir').click(function() {
	
	$.post('http://localhost/TreinamentoSoftbox/lancamento/excluir', {
		idLanc : idRegistro
	}, function(data) {
		if (data) {
			var classe = '#' + idRegistro;
			$(classe).remove();
			mensagem = 'O registro ' + '<strong>' + idRegistro + '</strong> foi excluido com <strong>sucesso</strong>!';
			
			$('#msgSuccess').html('<div class="alert alert-success alert-dismissible" role="alert">' +
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
											'<span aria-hidden="true">&times;</span>' +
										'</button>' +
										'<span class="content-msg">' + mensagem + '</span>' +
								  '</div>');
			
			$('#msgSuccess').show();

			idRegistro = null;
			$('#btnMdlCancelar').click();
			$('#hdOperacao').val('Novo');
		}
		
		return false;
	});
});

$('#btnLimpar').click(function() {
	limpaCamposLancamentos();
});

$('#cadastroLancamento').submit(function() {
	
	var operacao = $('#hdOperacao').val();
	var nomeCategoria;
	var nomeTipo;
	var url = operacao == "Novo" ? "http://localhost/TreinamentoSoftbox/lancamento/adicionar" : "http://localhost/TreinamentoSoftbox/lancamento/atualizar";
	
	if ($('#drpCategoria option').is(':selected')) {
		nomeCategoria = $('#drpCategoria :selected').html();
	}

	if ($('#drpTipo option').is(':selected')) {
		nomeTipo = $('#drpTipo :selected').html();
	}
	
	$.post(url, {
		
		nomeCategoria: nomeCategoria,
		nomeTipo: nomeTipo	,
		idCategoria: $('#drpCategoria').val(),
		tipo: $('#drpTipo').val(),
		valor: $('#txtValor').val(),
		dtLanc: $('#dtLancamento').val(),
		descricao: $('#txtDescricao').val(),
		idLanc: $('#hdIdLanc').val()
		
	}, function(data) {
		
		var classse = '';
		
		if (data.length == 0) {
			
			mensagem = data + '<stronger>Erro</stronger> ao tentar salvar registro. Por favor Verifique o campo descrição, pois não é permitido a inserção de um lançamento,' +
								'</br>com a descrição igual de outro já existente, na mesma data.';
			classse = 'danger';
		} else {
			
			classse = 'success';
			var linhaCorrente = '#' + $('#hdIdLanc').val();
			var body = '<td>' + data['nomeCategoria'] + '</td>' +
			   		   '<td>' + data['nomeTipo'] + '</td>' +
			   		   '<td>' + data['valor'] + '</td>' +
			   		   '<td>' + data['dtLanc'] + '</td>' +
			   		   '<td>' + data['descricao'] + '</td>' +
			   		   '<td>&nbsp;&nbsp;' +
			   		   		'<a href=\"#\" class=\"btnEditar\" id=\"' + data['idLanc'] + '\">' +
			   		   			'<i class=\"fa fa-pencil-square-o btn-success btn-circle\"></i>' +
			   		   		'</a>&nbsp;&nbsp;&nbsp;' + 
			   		   		'<a href=\"#\" data-target=\"#mdlExcluirReg\" class=\"btnExcluir\" id=\"' + data['idLanc'] + '\">' +
			   		   			'<i class=\"fa fa-times btn-danger btn-circle\"></i>' +
			   		   		'</a>' +
			   		   '</td>';
			
			
			if (operacao == 'Editar') {
				mensagem = 'Registro n° ' + '<strong>' + data['idCategoria'] + '</strong> foi alterado com <strong>sucesso</strong>!';
				
				$(linhaCorrente).html(body);
				
			} else {
				mensagem = 'O seu registro foi salvo com <strong>sucesso</strong>!<br>' +
				   			'N° registro - ' + '<strong>' + data['idLanc'] + '</strong> gerado.';

				$('#lancamentos').append('<tr id=\"' + data['idLanc'] + '\">' + body + '</tr>');
			}
			
			limpaCamposLancamentos();
		}
		
		$('#msgSuccess').html('<div class="alert alert-' + classse + ' alert-dismissible" role="alert">' +
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
											'<span aria-hidden="true">&times;</span>' +
									'</button>' +
									'<span class="content-msg">' + mensagem + '</span>' +
							  '</div>');
		
		$('#msgSuccess').show();
		
		$('.btnEditar').click(function() {
			btnEditar(this);
		});
		
	}, 'json');
	
	return false;
});


// end Eventos


// Métodos

function btnEditar(e) {
	
	var id = $(e).attr('id');
	
	$.post('http://localhost/TreinamentoSoftbox/lancamento/editar', {
		
		idLanc: id
		
	}, function(data) {
		// Remove a seleção do item atual
		$('#drpCategoria option').removeAttr('selected');
		$('#drpTipo option').removeAttr('selected');
		
		$('#hdIdLanc').val(id);
		$('#hdOperacao').val('Editar');
		
		$('#drpCategoria option[value=' + data['idCategoria'] + ']').attr('selected', true);
		$('#drpTipo option[value=' + data['tipo'] + ']').attr('selected', true);
		$('#txtValor').val(data['valor']);
		$('#dtLancamento').val(data['dtLanc']);
		$('#txtDescricao').val(data['descricao']);
		
		$('#btnLimpar').click(function() {
			limpaCamposLancamentos();
		});
		
	}, 'json');
	
}

function limpaCamposLancamentos() {
	
	$('#drpCategoria option').removeAttr('selected');
	$('#drpTipo option').removeAttr('selected');
	
	$('#hdOperacao').val('Novo');
	$('#hdCodLancamento').val('');
	$('#drpCategoria option:first').attr('selected', true);
	$('#drpTipo option:first').attr('selected', true);
	$('#txtValor').val('');
	$('#dtLancamento').val('');
	$('#txtDescricao').val('');
		
}