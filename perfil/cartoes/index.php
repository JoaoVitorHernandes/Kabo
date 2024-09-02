<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../../img/card.png" type="image/x-icon">
    <title>Cartões</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    include('../../connection.php');
    session_start();

    if (!isset($_SESSION['Cod_Usuario'])) {
        header("Location: ../../login/");
        exit();
    }

    $codUsuario = $_SESSION['Cod_Usuario'];
    $cartaoQuery = $conn->prepare("SELECT * FROM Cartao_pagamento WHERE fk_Cod_Usuario = ?");
    $cartaoQuery->bind_param("i", $codUsuario);
    $cartaoQuery->execute();
    $resultCartao = $cartaoQuery->get_result();

    if ($resultCartao === false) {
        echo "Erro na consulta SQL: " . $conn->error;
    }
    ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'exists') : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                color: 'white',
                background: '#1E1E1E',
                text: 'Você já tem um cartão com esse número! Por favor, insira outro número.',
            }).then((result) => {
                window.location.href = '../cartoes/';
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'added') : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                color: 'white',
                background: '#1E1E1E',
                text: 'Cartão adicionado com sucesso!',

            }).then((result) => {
                window.location.href = '../cartoes/';
            });
        </script>
    <?php endif; ?>

    <iframe src="../../barrasNav.php" frameborder="0" class="iframenav"></iframe>
    <section id="sectionCartoes">
        <div class="titulo">
            <img src="../../img/card.png" alt="">
            <p>Cartões de Pagamento</p>
            <p><?php echo $resultCartao->num_rows; ?> adicionados</p>
        </div>

        <div class="alignCartoes">
            <div class="addCartao" onclick="addCartao()">
                <p>+</p>
            </div>

            <?php while ($row = $resultCartao->fetch_assoc()) { ?>
                <div class="caixasCartao">
                    <div class="cartao">
                        <img src="../../img/mc_symbol.svg" alt="">
                        <div class="dadosInsideCartao">
                            <p>**** <?php echo substr($row['Numero'], -4); ?></p>
                            <p><?php echo $row['Nome_Titular']; ?></p>
                        </div>
                    </div>
                    <form class="dadosCartao">
                        <p id="nomeTitular"><?php echo $row['Nome_Titular']; ?></p>
                        <p id="numCartao"><?php echo $row['Numero'] ?></p>
                        <p id="dataVencimento"><?php echo date('m/Y', strtotime($row['Dt_Vencimento'])); ?></p>
                        <input type="button" class="editar" name="editar" value="Editar" onclick="abrirPopUp(<?php echo $row['Cod_Cartao']?>, '<?php echo $row['Nome_Titular']?>', '<?php echo date('m/Y', strtotime($row['Dt_Vencimento']))?>')">
                        <img src="../../img/lixeira.png" id="lixeira" onclick="abrirPopUpExcluir(<?php echo $row['Cod_Cartao']; ?>)">
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>

    <dialog id="addcartaoPopUp">
        <form method="post" action="addCartao.php" onsubmit="return verificar()">
            <div class="inputsPopUpAddCartao">
                <input type="text" name="nomeTitular" placeholder="Nome Titular" required>
                <input type="text" name="CPF" id="cpf" placeholder="CPF" oninput="this.value = maskCPF(this.value)" maxlength="14" required>
                <input type="text" name="vencimento" placeholder="Vencimento (MM/YYYY)" required>
                <input type="text" name="CVC" placeholder="CVC" required maxlength="3">
                <input type="text" name="numero" placeholder="Número" required>
            </div>
            <menu>
                <button id="cancelAddCartao" type="reset" onclick="fecharPopUpaddCartao()">Cancel</button>
                <button type="submit" id="enviarSubmit" name="enviarSubmit">Enviar</button>
            </menu>
        </form>
    </dialog>

    <dialog id="dialogErro">
        <h3 id="dialogTitulo">Erro</h3>
        <p id="avisoDialog"></p>
        <button id="botaoDialog">Ok</button>
    </dialog>

    <script>
        // função modal
        function showDialog(titulo, texto) {
            var dialog = document.querySelector('#dialogErro');
            var dialogTitulo = document.querySelector('#dialogTitulo');
            var avisoDialog = document.querySelector('#avisoDialog');
            var botaoDialog = document.querySelector('#botaoDialog');

            dialogTitulo.textContent = titulo;
            avisoDialog.textContent = texto;
            botaoDialog.textContent = 'Ok';

            botaoDialog.onclick = function() {
                dialog.classList.add('fadeOut');
                setTimeout(function() {
                    dialog.close();
                    dialog.classList.remove('fadeOut');
                }, 201);
            };

            dialog.classList.remove('fadeOut');
            dialog.showModal();
        }


        // mascara cpf
        const txtCPF = document.getElementById('cpf')

        function verificar() {
            if (isCPFValido(txtCPF.value) && validarCPF(txtCPF.value)) {
                txtCPF.style.borderColor = 'green'
            } else {
                txtCPF.style.borderColor = 'red'
                showDialog('CPF inválido!', 'Verifique o CPF digitado.')
                return false
            }
        }

        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '')
            let soma = 0
            let resto
            for (let i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i)
            }
            resto = 11 - (soma % 11);
            if (resto === 10 || resto === 11) {
                resto = 0
            }
            if (resto !== parseInt(cpf.charAt(9))) {
                return false
            }
            soma = 0
            for (let i = 0; i < 10; i++) {
                soma += parseInt(cpf.charAt(i)) * (11 - i)
            }
            resto = 11 - (soma % 11);
            if (resto === 10 || resto === 11) {
                resto = 0
            }
            if (resto !== parseInt(cpf.charAt(10))) {
                return false
            }
            return true
        }

        function isCPFValido(cpf) {
            const reC = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/
            return reC.test(cpf)
        }

        function maskCPF(value) {
            return value
                .replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{2})$/, '$1-$2')
        }



        var numeroCartaoInput = document.querySelector('input[name="numero"]');
        numeroCartaoInput.addEventListener('input', function() {
            var numeroCartao = this.value.replace(/\D/g, '');

            if (numeroCartao.length > 16) {
                numeroCartao = numeroCartao.substring(0, 16);
            }

            this.value = numeroCartao;
        });


        // mascara vencimento
        var vencimentoInput = document.querySelector('input[name="vencimento"]');
        vencimentoInput.addEventListener('input', function() {
            var vencimento = this.value.replace(/\D/g, '');

            if (vencimento.length > 2) {
                vencimento = vencimento.substring(0, 2) + '/' + vencimento.substring(2);
            }

            if (vencimento.length > 7) {
                vencimento = vencimento.substring(0, 7);
            }

            this.value = vencimento;

            if (vencimento.length === 7) {
                var partesData = vencimento.split('/');
                var mes = parseInt(partesData[0]);
                var ano = parseInt(partesData[1]);
                var dataVencimento = new Date(ano, mes - 1);
                var dataAtual = new Date();
                var mesAtual = dataAtual.getMonth() + 1;

                if (ano < 2024 || ano > 2040 || mes < 1 || mes > 12) {
                    this.value = '';
                } else if (ano < dataAtual.getFullYear() || (ano === dataAtual.getFullYear() && mes < mesAtual)) {
                    this.value = '';
                }
            }
        });


        var nomeTitularInput = document.querySelector('input[name="nomeTitular"]');
        nomeTitularInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
        });


        var cvcInput = document.querySelector('input[name="CVC"]');
        cvcInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <dialog id="popUp" class="dialog">
        <form method="post" action="editar.php">
            <section>
                <div>
                    <label for="titularCartao">Titular do Cartão</label>
                    <input type="text" id="titularCartao" name="titular_cartao">
                </div>

                <div>
                    <label for="dataVencimento">Data Vencimento</label>
                    <input type="text" id="dataVencimentoPopUp" name="data_vencimento">
                </div>
            </section>
            <menu>
                <input type="hidden" name="cod_cartao" value="" id="hiddenInputEditar">
                <button id="cancel" type="reset" onclick="fecharPopUp()">Cancel</button>
                <button type="submit" id="enviarSubmit" name="enviarSubmit">Enviar</button>
            </menu>
        </form>
    </dialog>

    <script>
        // mascara nome titular e vencimente popup editar
        var nomeTitularPopUp = document.querySelector('input[name="titular_cartao"]');
        nomeTitularPopUp.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
        });

        // mascara vencimento
        var vencimentoPopUp = document.querySelector('input[name="data_vencimento"]');
        vencimentoPopUp.addEventListener('input', function() {
            var vencimento = this.value.replace(/\D/g, '');

            if (vencimento.length > 2) {
                vencimento = vencimento.substring(0, 2) + '/' + vencimento.substring(2);
            }

            if (vencimento.length > 7) {
                vencimento = vencimento.substring(0, 7);
            }

            this.value = vencimento;

            if (vencimento.length === 7) {
                var partesData = vencimento.split('/');
                var mes = parseInt(partesData[0]);
                var ano = parseInt(partesData[1]);
                var dataVencimento = new Date(ano, mes - 1);
                var dataAtual = new Date();
                var mesAtual = dataAtual.getMonth() + 1;

                if (ano < 2024 || ano > 2040 || mes < 1 || mes > 12) {
                    this.value = '';
                } else if (ano < dataAtual.getFullYear() || (ano === dataAtual.getFullYear() && mes < mesAtual)) {
                    this.value = '';
                }
            }
        });
    </script>

    <dialog id="popUpExcluir" class="dialog">
        <form method="post" action="delete.php">
            <p id="textoExcluir">Excluir Cartão?</p>
            <menu>
                <input type="hidden" name="cod_cartao" value="" id="hiddenInput">
                <button id="cancel" type="reset" onclick="fecharPopUpExcluir()">Cancel</button>
                <button type="submit" id="confirmarSubmit" name="confirmarExcluir">Confirmar</button>
            </menu>
        </form>
    </dialog>

    <script>
        function abrirPopUp(idEditar, nomeTitular, dataVencimento) {
            var favDialog = document.getElementById("popUp");
            favDialog.showModal();
            $("#hiddenInputEditar").val(idEditar);
            $("#titularCartao").val(nomeTitular);
            $("#dataVencimentoPopUp").val(dataVencimento);
        }

        function fecharPopUp() {
            var favDialog = document.getElementById("popUp");
            favDialog.close();
        }

        function abrirPopUpExcluir(id) {
            var excluir = document.getElementById("popUpExcluir");
            $("#hiddenInput").val(id);
            excluir.showModal();
        }

        function fecharPopUpExcluir() {
            var excluir = document.getElementById("popUpExcluir");
            excluir.close();
        }

        function addCartao() {
            var addPopUp = document.getElementById("addcartaoPopUp");
            addPopUp.showModal();
        }

        function fecharPopUpaddCartao() {
            var addPopUp = document.getElementById("addcartaoPopUp");
            addPopUp.close();
        }
    </script>
</body>

</html>