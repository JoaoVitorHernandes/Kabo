/* função voltar */
function voltar() {
    window.history.back();
}


/* função para aparecer divEntregaResumo quando clicar em continuar */
$(document).ready(function () {
    $('#botaoFinalizarCesta').click(function () {
        var parentWidth = $('#divCestaProdutos').parent().width();
        var newCestaWidth = parentWidth * 0.666;
        var newResumoWidth = parentWidth * 0.333;
        var buttonHeight = $(this).outerHeight(true);
        var currentCestaHeight = $('#divCestaProdutos').outerHeight();
        var newCestaHeight = currentCestaHeight - buttonHeight;

        $('#divCestaProdutos').animate({
            width: newCestaWidth,
            height: newCestaHeight
        }, 650);

        $('#divEntregaResumo').css({
            display: 'block',
            width: '0px'
        }).animate({
            width: newResumoWidth + 'px'
        }, 0);

        $(this).fadeOut('fast');
    });
});


/* função para aparecer adicionar cupom */
document.getElementById('maisCupom').addEventListener('click', function () {
    var formCupom = document.getElementById('formCupom');
    var maisCupom = document.getElementById('maisCupom');
    if (formCupom.style.display === 'none' || formCupom.style.display === '') {
        $(formCupom).fadeIn(200);
        formCupom.style.display = 'flex';
        $(maisCupom).fadeOut(0);
    } else {
        $(formCupom).fadeOut('fast');
        $(maisCupom).fadeIn('fast');
    }
});


/* crud carrinho */
$(document).ready(function () {
    function atualizarSoma() {
        var soma = 0;
        $('.number-quantity').each(function () {
            soma += parseInt($(this).val());
        });
        $('#qtdCarrinho').text(soma + ' itens');
    }

    $('.number-quantity').change(function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        $.ajax({
            url: 'quantidadeCarrinho.php',
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                console.log(response);
            }
        });

        if ($(this).val() == 0) {
            $(this).closest('.itemCesta').fadeOut(200);
        }

        atualizarSoma();
    });

    $('.removerItem').click(function () {
        $(this).closest('.itemCesta').find('.number-quantity').val(0).trigger('change');
    });

    atualizarSoma();
});


/* função pra aumentar a quantidade do item */
$(document).ready(function () {
    $('.number-right').click(function () {
        var input = $(this).siblings('.number-quantity');
        var valorAtual = parseInt(input.val());
        var valorMaximo = parseInt(input.attr('max'));
        var avisoEstoqueMaximo = $(this).siblings('.estoqueMaximoQtd');

        if (valorAtual < valorMaximo) {
            input.val(valorAtual + 1).trigger('change');
            avisoEstoqueMaximo.css('display', 'none');
        }

        if (valorAtual + 1 >= valorMaximo) {
            $(this).css('display', 'none');
            avisoEstoqueMaximo.css('display', 'block');
        }
    });
});


/* função para diminuir a quantidade do item */
$('.number-left').click(function () {
    var input = $(this).siblings('.number-quantity');
    var valorAtual = parseInt(input.val());
    var valorMinimo = parseInt(input.attr('min'));
    var avisoEstoqueMaximo = $(this).siblings('.estoqueMaximoQtd');

    if (valorAtual > valorMinimo) {
        input.val(valorAtual - 1).trigger('change');
        if (valorAtual - 1 < parseInt(input.attr('max'))) {
            $(this).siblings('.number-right').css('display', 'block');
            avisoEstoqueMaximo.css('display', 'none'); // Oculta o aviso
        }
    }

    if (valorAtual - 1 == 0) {
        $(this).closest('.itemCesta').find('.removerItem').click();
    }
});

/* função para atualizar subtotal de acordo com o preço dos itens */
$(document).ready(function () {
    function atualizarSubtotal() {
        var subtotal = 0;
        $('.precoItem').each(function () {
            var precoItemText = $(this).text().replace('R$', '').replace(',', '.');
            var precoItem = parseFloat(precoItemText);
            if (!isNaN(precoItem)) {
                subtotal += precoItem;
            }
        });
        $('#valorSubtotal').text('R$ ' + subtotal.toFixed(2).replace('.', ','));

        // atualiza o valor total final
        var valorTotalFinalText = $('#valorTotalFinal').text().replace('R$', '').replace('.', '').replace(',', '.');
        var valorTotalFinal = parseFloat(valorTotalFinalText);
        if (!isNaN(valorTotalFinal)) {
            $('#valorTotalFinal').text('R$ ' + subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

            // verifica se o cupom de desconto foi usado
            if ($('#cupomUsado').text().trim() !== '') {
                // Remove o cupom de desconto
                $('#cupomUsado').text('').fadeOut(function () {
                    // mostra o formulário do cupom
                    $('#formCupom').fadeIn();
                    $('#descontoAplicado').val('');
                    $('#codCupom').val('');
                });
            }
        }
    }


    /* função para atualizar o preço dos itens */
    $(document).ready(function () {
        $('.number-quantity').on('change keyup', function () {
            var quantidade = parseInt($(this).val());
            var precoUnitarioText = $(this).closest('.itemCesta').find('.precoInvisivel').text().replace('R$', '').replace(',', '.');
            var precoUnitario = parseFloat(precoUnitarioText);
            if (!isNaN(quantidade) && !isNaN(precoUnitario)) {
                var precoTotal = (precoUnitario * quantidade).toFixed(2);
                $(this).closest('.itemCesta').find('.precoItem').text('R$ ' + precoTotal.replace('.', ','));
                var parcelamento = (precoTotal / 10).toFixed(2);
                $(this).closest('.itemCesta').find('.parcelamentoCesta').text('10 x R$ ' + parcelamento.replace('.', ',') + ' sem juros no cartão');
            }
            atualizarSubtotal();
        }).trigger('change');
    });

    /* função para esvaziar carrinho */
    $('#esvaziarCarrinho').click(function () {
        $('.number-quantity').val(0).trigger('change');
        setTimeout(function () {
            window.location.href = "../carrinho/";
        }, 200);
    });

    /* função para remover item individual */
    $('.removerItem').click(function () {
        $(this).closest('.itemCesta').find('.number-quantity').val(0).trigger('change');
        var existeItem = false;
        $('.number-quantity').each(function () {
            if (parseInt($(this).val()) > 0) {
                existeItem = true;
                return false;
            }
        });
        if (!existeItem) {
            setTimeout(function () {
                window.location.href = "../carrinho/";
            }, 200);
        }
    });
    // atualiza o subtotal quando a página é carregada
    atualizarSubtotal();
});


/* função para adicionar cupom de desconto */
$(document).ready(function () {
    $('#formCupom').submit(function (e) {
        e.preventDefault();
        var dadosFormulario = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'addCupom.php',
            data: dadosFormulario,
            success: function (response) {
                var desconto = parseFloat(response.split(',')[0]);
                var codCupom = response.split(',')[1];
                if (desconto > 0) {
                    var valorTotalFinalText = $('#valorTotalFinal').text().replace('R$', '').replace('.', '').replace(',', '.');
                    var valorTotalFinal = parseFloat(valorTotalFinalText);
                    if (!isNaN(valorTotalFinal)) {
                        var valorComDesconto = valorTotalFinal - (valorTotalFinal * (desconto / 100));
                        $('#valorTotalFinal').text('R$ ' + valorComDesconto.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                        // adiciona o desconto e o código do cupom aos inputs
                        $('#descontoAplicado').val(desconto);
                        $('#codCupom').val(codCupom);

                        // esconde o formulário do cupom com um efeito de fade out
                        $('#formCupom').fadeOut(function () {
                            // mostra o cupom usado com um efeito de fade in
                            $('#cupomUsado').text('- R$ ' + (valorTotalFinal - valorComDesconto).toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })).fadeIn();
                        });
                    }
                } else {
                    // limpa o campo de entrada e altera o placeholder
                    $('#formCupom input').val('').attr('placeholder', response);
                }
            }
        });
    });
});


/* função para parcelamento */
$(document).ready(function () {
    // função para atualizar as opções de parcelamento
    function atualizarParcelamento() {
        var valorTotalFinalText = $('#valorTotalFinal').text().replace('R$', '').replace('.', '').replace(',', '.');
        var valorTotalFinal = parseFloat(valorTotalFinalText);
        if (!isNaN(valorTotalFinal)) {
            $('#selectParcelamento option').each(function () {
                var parcelas = $(this).index() + 1;
                var valorParcela = valorTotalFinal / parcelas;
                $(this).text(parcelas + 'x R$ ' + valorParcela.toFixed(2).replace('.', ',') + ' sem juros');
            });
        }
    }
    // atualiza as opções de parcelamento sempre que o valor total final muda
    $('#valorTotalFinal').on('DOMSubtreeModified', function () {
        atualizarParcelamento();
    });
});


/* função para atualizar o parcelamento final */
$(document).ready(function () {
    // Função para atualizar o texto do parcelamento final
    function atualizarTextoParcelamentoFinal() {
        var textoParcelamento = $('#selectParcelamento').find('option:selected').text();
        $('#textParceFinalizar').text(textoParcelamento + ' no cartão');
    }
    // Atualiza o texto do parcelamento final com o valor inicial do select
    $(window).on('load', function () {
        atualizarTextoParcelamentoFinal();
    });
    // Atualiza o texto do parcelamento final sempre que a opção de parcelamento selecionada muda
    $('#selectParcelamento').change(atualizarTextoParcelamentoFinal);
});


/* função para atualizar o valor da compra */
$(document).ready(function () {
    // Função para atualizar o valor da compra
    function atualizarValorCompra() {
        var valorTotalFinalText = $('#valorTotalFinal').text().replace('R$', '').replace('.', '').replace(',', '.');
        var valorTotalFinal = parseFloat(valorTotalFinalText);
        if (!isNaN(valorTotalFinal)) {
            $('#valorCompra').val(valorTotalFinal);
        }
    }
    // atualiza o valor da compra com o valor inicial do valor total final
    $(window).on('load', function () {
        atualizarValorCompra();
    });
    // atualiza o valor da compra sempre que o valor total final muda
    $('#valorTotalFinal').on('DOMSubtreeModified', atualizarValorCompra);
});


// Define o valor padrão de #selectCartao e #cartaoSelecionado
$(document).ready(function () {
    $('#selectCartao').prop('selectedIndex', 0);
    $('#cartaoSelecionado').val($('#selectCartao').val());

    $('#selectCartao').change(function () {
        var valorSelecionado = $(this).val();
        if (valorSelecionado === 'novo') {
            // Define o valor de #cartaoSelecionado como vazio
            $('#cartaoSelecionado').val('');
            // Redireciona o usuário para a página de cadastro de novo cartão após uma pequena pausa
            setTimeout(function () {
                window.location.href = '../perfil/cartoes/';
            }, 100);
        } else {
            // Atualiza o input #cartaoSelecionado com o número do cartão selecionado
            $('#cartaoSelecionado').val(valorSelecionado);
        }
    });
});
$(window).on('load', function () {
    // Define o valor padrão de #selectCartao e #cartaoSelecionado
    $('#selectCartao').prop('selectedIndex', 0);
    $('#cartaoSelecionado').val($('#selectCartao').val());
});


/* função para finalizar compra */
$(document).ready(function () {
    $('#botaoFinalizarCompra').click(function (event) {
        event.preventDefault();

        var descontoAplicado = $('#descontoAplicado').val();
        var codCupom = $('#codCupom').val();
        var valorCompra = $('#valorCompra').val();
        var cartaoSelecionado = $('#cartaoSelecionado').val();

        if (cartaoSelecionado === '') {
            var dialog = document.querySelector('#dialogErro');
            var dialogTitulo = document.querySelector('#dialogTitulo');
            var avisoDialog = document.querySelector('#avisoDialog');
            var botaoDialog = document.querySelector('#botaoDialog');

            dialogTitulo.textContent = 'Erro ao finalizar compra';
            avisoDialog.textContent = 'Por favor, adicione um cartão antes de finalizar a compra!';
            botaoDialog.textContent = 'Ok';

            botaoDialog.onclick = function () {
                dialog.classList.add('fadeOut');
                setTimeout(function () {
                    dialog.close();
                }, 201);
            };

            dialog.classList.remove('fadeOut');
            dialog.showModal();
            return;
        }

        $.ajax({
            url: 'finalizarCompra.php',
            type: 'POST',
            data: {
                desconto: descontoAplicado,
                codCupom: codCupom,
                valorTotal: valorCompra,
                cartaoSelecionado: cartaoSelecionado
            },
            success: function (response) {
                if (response.trim() === 'Compra finalizada') {
                    window.location.href = '../perfil/pedidos/';
                } else if (response.trim() === 'Carrinho vazio') {
                    window.location.reload();
                } else {
                    var responses = JSON.parse(response);

                    if (responses.length > 0) {
                        // Abre o diálogo
                        var dialog = document.querySelector('#dialogErro');
                        dialog.showModal();

                        // Adiciona um ouvinte de evento ao botão
                        document.querySelector('#botaoDialog').addEventListener('click', function () {
                            for (var i = 0; i < responses.length; i += 2) {
                                // Encontra o input correspondente usando o código do produto
                                var input = document.querySelector('input[name="Cod_Produto"][value="' + responses[i] + '"]').parentNode.querySelector('.number-quantity');

                                // Atualiza a quantidade
                                input.value = responses[i + 1];

                                // Atualiza o atributo value
                                input.setAttribute('value', responses[i + 1]);

                                // Dispara o evento change
                                input.dispatchEvent(new Event('change'));
                            }

                            // Fecha o diálogo
                            dialog.close();

                            // Verifica se ainda existem produtos no carrinho
                            var existeItem = false;
                            document.querySelectorAll('.number-quantity').forEach(function (input) {
                                if (parseInt(input.value) > 0) {
                                    existeItem = true;
                                    return false;
                                }
                            });
                            if (!existeItem) {
                                setTimeout(function () {
                                    window.location.href = "../carrinho/";
                                }, 200);
                            }
                        });
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Trata o erro AJAX
                console.error('Erro AJAX: ', textStatus, ', ', errorThrown);
            }
        });
    });
});