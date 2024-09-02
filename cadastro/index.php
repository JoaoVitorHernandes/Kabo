<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <title>Cadastro</title>
</head>

<body>
    <script>
        // Função para mostrar a imagem selecionada na edição do perfil
        function validaImagem(input) {
            var caminho = input.value;

            if (caminho) {
                var comecoCaminho = (caminho.indexOf('\\') >= 0 ? caminho.lastIndexOf('\\') : caminho.lastIndexOf('/'));
                var nomeArquivo = caminho.substring(comecoCaminho);

                if (nomeArquivo.indexOf('\\') === 0 || nomeArquivo.indexOf('/') === 0) {
                    nomeArquivo = nomeArquivo.substring(1);
                }

                var extensaoArquivo = nomeArquivo.indexOf('.') < 1 ? '' : nomeArquivo.split('.').pop();

                if (extensaoArquivo != 'gif' &&
                    extensaoArquivo != 'png' &&
                    extensaoArquivo != 'jpg' &&
                    extensaoArquivo != 'jpeg') {
                    input.value = '';
                    showDialog('Erro', "É preciso selecionar um arquivo de imagem (gif, png, jpg ou jpeg)");
                }
            } else {
                input.value = '';
                showDialog('Erro', "Selecione um caminho de arquivo válido");
            }
            if (input.files && input.files[0]) {
                var arquivoTam = input.files[0].size / 1024 / 1024;
                if (arquivoTam < 16) {
                    var reader = new FileReader();
                    reader.onload = function(e) {

                        document.getElementById(`imagemCadastro`).style.visibility = "visible";
                        document.getElementById(`imagemCadastro`).setAttribute('src', e.target.result);


                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    input.value = '';
                    showDialog('Erro', "O arquivo precisa ser uma imagem com menos de 16 MB");
                }
            } else {

                document.getElementById(`imagemCadastro`).setAttribute('src', '#');
            }
        }
    </script>

    <main>
        <section class="box">
            <span id="X" onclick="voltarPagina()">&times;</span>

            <div class="alinharelementos">
                <a href="../"><img src="../img/logo_neon.png" alt="logo" id="logo"></a>
            </div>

            <div class="alinharelementosescrita">
                <p id="elemento1">Fazer Cadastro</p>
                <p id="elemento2">Digite seus dados e crie uma senha</p>
            </div>

            <form id="form1" name="form1" method="post" action="cadastro_php.php" onsubmit="return verificar()" enctype="multipart/form-data">
                <div class="espacodentrobox">

                    <div class="div_input_imagem">
                        <label for="input_file" class="label_input_file">Foto perfil</label>
                        <input type="file" id="input_file" class="input_file" name="imgPerfil" onchange="validaImagem(this);">
                        <img src="" id="imagemCadastro" class="imagePreview" alt="Foto perfil">
                    </div>

                    <input type="text" name="txtNome" value="" maxlength="100" id="primeiroinput" placeholder="Nome" class="campocheio" required>

                    <input type="text" placeholder="CPF" id="cpf" name="txtCPF" value="" oninput="this.value = maskCPF(this.value)" maxlength="14" class="campomedio" required>
                    <select name="selectGenero" id="genero" class="campomedio" required>
                        <option value="" disabled selected>Gênero</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>

                    <input type="date" placeholder="Data de nascimento" id="nascimento" name="dateData_Nasc" oninput="this.value = maskData(this.value)" class="campomedio" required>
                    <input type="text" placeholder="CEP" id="CEP" name="txtCEP" value="" oninput="this.value = maskCEP(this.value); buscarCEP(this.value);" maxlength="9" class="campomedio" required>

                    <input type="text" placeholder="Logradouro" id="logradouro" name="txtLogradouro" value="" class="campocheio" maxlength="150" required>
                    <input type="text" placeholder="Bairro" id="bairro" name="txtBairro" value="" class="campomedio" maxlength="50" required>
                    <input type="number" placeholder="Numero" id="numero" name="txtNumero" value="" class="campomedio" oninput="limitarNumero(this)" min="0" required>
                    <input type="text" placeholder="Cidade" id="cidade" name="txtCidade" value="" class="campomedio" maxlength="50" required>
                    <input type="text" placeholder="Estado" id="estado" name="txtEstado" value="" class="campomedio" maxlength="2" required>

                    <input type="email" name="email" id="email" value="" placeholder="E-mail" maxlength="100" class="campocheio" required>

                    <p id="regraSenha">A senha deve ter ao menos uma letra maiúscula e minúscula e um número. Ao todo, no mínimo oito caracteres.</p>
                    <input type="password" name="txtSenhaNova" value="" id="senhaNova" placeholder="Digite a senha" class="campocheio" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <input type="password" name="txtSenha" value="" id="senhaConfirmar" placeholder="Confirme a senha" class="campocheio" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                </div>
                <input type="submit" value="Criar conta" id="enviarsubmit">
            </form>
            <p id="folhascopy"><a href="../">&copy;kabo</a></p>
        </section>
    </main>

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


        const txtSenhaNova = document.getElementById('senhaNova')
        const txtSenhaConfirmar = document.getElementById('senhaConfirmar')
        const txtNome = document.getElementById('primeiroinput')
        const txtCPF = document.getElementById('cpf')
        const txtCEP = document.getElementById('CEP')
        const txtLogradouro = document.getElementById('logradouro')
        const txtBairro = document.getElementById('bairro')
        const txtCidade = document.getElementById('cidade')
        const txtestado = document.getElementById('estado')
        const email = document.getElementById('email')

        function limitarNumero(input) {
            var maxLength = 5;
            var valor = input.value;
            if (valor.length > maxLength) {
                input.value = valor.slice(0, maxLength);
            }
        }

        function buscarCEP(cep) {
            // Verifica se o CEP possui o formato correto
            if (/^\d{5}-\d{3}$/.test(cep)) {
                // Faz a requisição para a API do ViaCEP
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            // Preenche os campos de endereço com os dados retornados pela API
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            showDialog('Erro', 'CEP não encontrado');
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        }

        function verificar() {
            if (isNomeValido(txtNome.value)) {
                if (isCPFValido(txtCPF.value) && validarCPF(txtCPF.value)) {
                    if (isCEPValido(txtCEP.value)) {
                        if (isEmailValido(email.value)) {
                            if (isNomeValido(txtLogradouro.value)) {
                                if (isNomeValido(txtBairro.value)) {
                                    if (isNomeValido(txtCidade.value)) {
                                        if (isNomeValido(txtestado.value)) {
                                            if (txtSenhaNova.value === txtSenhaConfirmar.value) {
                                                return true
                                            } else {
                                                showDialog('Erro', 'As senhas não combinam!')
                                                return false
                                            }
                                        } else {
                                            showDialog('Erro', 'Estado inválido!')
                                            return false
                                        }
                                    } else {
                                        showDialog('Erro', 'Cidade inválido!')
                                        return false
                                    }
                                } else {
                                    showDialog('Erro', 'Bairro inválido!')
                                    return false
                                }
                            } else {
                                showDialog('Erro', 'Logradouro inválido!')
                                return false
                            }
                        } else {
                            showDialog('Erro', 'Email inválido!')
                            return false
                        }
                    } else {
                        showDialog('Erro', 'CEP inválido!')
                        return false
                    }
                } else {
                    showDialog('Erro', 'CPF inválido!')
                    return false
                }
            } else {
                showDialog('Erro', 'Nome inválido!')
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

        function isNomeValido(nome) {
            const reN = /^\w*[a-zA-ZÀ-ú\s]+$/
            return reN.test(nome)
        }

        function isCPFValido(cpf) {
            const reC = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/
            return reC.test(cpf)
        }

        function isCEPValido(cep) {
            const reCE = /^\d{5}-\d{3}$/
            return reCE.test(cep)
        }

        function isEmailValido(email) {
            const reEM = /^\w.+@\w{3}.*\.\w{2,3}$/
            return reEM.test(email)
        }

        function maskCPF(cpf) {
            return cpf.trim().replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
        }

        function maskCEP(cep) {
            return cep.trim().replace(/^(\d{5})(\d{3})$/, '$1-$2')
        }

        function maskData(data) {
            const minDate = new Date('1900-01-01');
            const maxDate = new Date();

            const enteredDate = new Date(data.split('/').reverse().join('-'));

            if (enteredDate < minDate || enteredDate > maxDate) {
                return data; // Retorna a data original se estiver fora do intervalo
            }

            return formatted;
        }

        let today = new Date().toISOString().split('T')[0];
        document.getElementById('nascimento').setAttribute('max', today);

        function voltarPagina() {
            window.history.back();
        }
    </script>

</body>

</html>