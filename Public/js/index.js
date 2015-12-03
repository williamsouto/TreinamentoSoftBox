
// Variáveis globais
var collapsad = false;
var menuLateral = false;
var bannerDown = false;
var bannerFim = false;
var countNot = 0;
var atual = 0;
var array = [ "Digite", " aqui", " .", " .", " .", "" ];
var idRegistro;
var dataChart;

// End Variáveis globais

// Timers
var intervalo = setInterval(verificarAnimacao, 100);
var intervaloNot = setInterval(animarNotificacao, 3000);
setInterval(campoPesquisar, 1000);
setInterval(animarPonteiro, 1000);

// Loads
$().ready(function() {
	
	$('#msgSuccess').hide();
	var titulo = $(".navbar-collapse > span").text().split(' ');
	
	if (titulo[2] == 'Home') {
		animarBanners();
	} else {
		var margin = deslocaTitulo();
		animarTitulo(margin);
	}
	
	$.getJSON("http://localhost/TreinamentoSoftbox/home/chart", function(data) {
		criarGrafico(data);
		dataChart = data;
    });
});

// Eventos

$('#banner').click(function() {

	var obj = $('#banner');

	obj.fadeOut(2000, function() {
		obj.show();
	});
	obj.fadeOut(800, function() {
		obj.show();
	});
	obj.fadeOut(800, function() {
		obj.show();
	});
});

$('#drop-notificacao').click(function() {
	$('.badge-notificacao').text(0);
});

$('.ponteiro').click(function() {

	if (!collapsad) {
		$('.menu-lateral').animate({
							width : "-=169"	
		},350, function() {
			$('.ponteiro > i').removeClass('fa-chevron-circle-left').addClass('fa-chevron-circle-right');
			
			var url = (window.location.href).split('/');
			
			if (url[4].length <= 5) {
				criarGrafico(dataChart);
			}
		});
		
		$('.ponteiro').animate({
			left : '6%'
		}, 350);
		
		collapsad = true;
		
	} else {
		
		$('.menu-lateral').animate({
			width : "+=169"
		}, 350, function() {
			$('.ponteiro > i').removeClass('fa-chevron-circle-right').addClass('fa-chevron-circle-left');
			
			var url = (window.location.href).split('/');
			
			if (url[4].length <= 5) {
				criarGrafico(dataChart);
			}
			
		});
			
		$('.ponteiro').animate({
			left : '15%'
		}, 350);
	
		collapsad = false;
	}
	
});

$('.ponteiro').click(function() {

	if (!menuLateral) {
		$('.bg-body').animate({
			marginLeft : '-=160'
		}, 350);
		menuLateral = true;
	} else {
		$('.bg-body').animate({
			marginLeft : '+=160'
		}, 350);
		menuLateral = false;
	}
});

$('.banner-content').mouseover(function() {
	$(this).removeClass('banner-conten');
	$(this).addClass('banner-content-hover');
});

$('.banner-content').mouseout(function() {
	$(this).removeClass('banner-content-hover');
	$(this).addClass('banner-content');
});

// EndEventos

// Métodos

function criarGrafico(data) {
	
	chart = new Highcharts.Chart({
        chart: {
            renderTo: 'chart',
            type: 'line',
            marginRight: 130,
            marginBottom: 30
        },
        title: {
            text: 'Receitas vs. Despesas',
            x: -20 //center
        },
        subtitle: {
            text: 'Ano 2015',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Agos', 'Set', 'Out', 'Nov', 'Dez']
        },
        yAxis: {
            title: {
                text: 'Lançamentos'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
            
            type: 'linear'
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': R$ '+ this.y;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: 100,
            borderWidth: 0
        },
        series: data
    });
	
}

function verificarAnimacao() {

	if (parseInt($('.banner-blue').height()) <= 140 && bannerDown == true) {
		bannerDown = false;

		$('.banner-blue').stop();
		$('.banner-blue').slideDown(800, function() {
			bannerFim = true;
			$('.banner-blue').slideUp(1000);
		});
	} else if (parseInt($('.banner-blue').height()) <= 180 && bannerFim == true) {
		$('.banner-blue').stop();
		$('.banner-blue').slideDown(800);
		clearInterval(intervalo);
	}
}

function animarTitulo(margin) {
	
	$(".navbar-collapse > span").animate({
		left : "+=" + margin.toString() + ""
	}, 350);
}

function animarBanners() {

	var margin = deslocaTitulo();

	$('.banner-yellow').css('left', '520px');
	$('.banner-yellow').animate({
		left : "-=520px"
	}, 350);

	$('.banner-green').css('left', '-800px');
	$('.banner-green').animate({
		left : "0px"
	}, 350, function() {
		animarTitulo(margin);
	});

	$('.banner-blue').hide();
	$('.banner-blue').slideDown(700, function() {
		bannerDown = true;
		$('.banner-blue').slideUp(900);
	});
}

function deslocaTitulo() {
	var margin = parseInt($('.navbar-collapse > span').css("margin-left"));
	margin = margin + 600;
	
	$(".navbar-collapse > span").css("margin-left", "-600px").css("position",
			"relative");
	
	return margin;
}

function animarPonteiro() {
	$('#ponteiro > i').animate({
		width : '500',
		height : '+=500'
	}, 400, function() {
		$('#ponteiro > i').animate({
			width : '500',
			height : '+=500'
		}, 400);
	});
}

function animarNotificacao() {
	if (countNot <= 5) {
		$('#notificacao').addClass('notificacao');
		setTimeout(function() {
			$('#notificacao').removeClass('notificacao');
		}, 2000);
		countNot++;
	} else {
		clearInterval(intervaloNot);
	}
}

function campoPesquisar() {
	document.getElementById("txtPesquisar").placeholder += array[atual];

	if (atual == 5) {
		atual = 0;
		document.getElementById("txtPesquisar").placeholder = array[5];
	} else {
		atual++;
	}
}

// EndMetodos

