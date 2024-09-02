// editar quantidade do produto antes de enviar para o carrinho
$(document).ready(function() {
    $("#incrementButton, #decrementButton").click(function() {
        var value = parseInt($("#numberInput").val(), 10);
        var max = parseInt($("#numberInput").attr('max'), 10);
        value = isNaN(value) ? 0 : value;
        if((value < max && this.id == 'incrementButton') || (value > 1 && this.id == 'decrementButton')) {
            value = (this.id == 'incrementButton') ? value + 1 : value - 1;
            $("#numberInput").val(value);
            $(".buttonAdded, #botaoLoginNecessario").fadeOut(0);
            $(".buttonAdd").fadeIn();
        }
    });
});


// função para adicionar produto ao carrinho usando ajax
$(document).ready(function () {
    $(".buttonAdd").click(function () {
        var quantidade = $("#numberInput").val();
        var codProduto = $("#codProduto").val();
        var usuario = $("#codUsuario").val();

        if(usuario == '') {
            $(this).fadeOut(function() {
                $("#botaoLoginNecessario").fadeIn().find('p').text('Login necessário');
                setTimeout(function() {
                    $("#botaoLoginNecessario").find('p').text('Fazer login');
                    $("#botaoLoginNecessario").click(function() {
                        window.location.href = '../login/';
                    });
                }, 2000);
            });
        } else {
            $.post("../addProdutoCart.php",
                {
                    quantidade: quantidade,
                    codProduto: codProduto
                },
                function (data, status) {
                    console.log("Status: " + status + "\n" + data);
                    if(data.trim() == "Estoque esgotado!") {
                        location.reload();
                    } else {
                        $(".buttonAdd").fadeOut(function() {
                            $(".buttonAdded").fadeIn();
                        });
                    }
                });
        }
    });
});