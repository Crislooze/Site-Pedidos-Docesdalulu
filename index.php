<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'informa5_teste';
$user = 'informa5_teste';  // Altere para o usuário correto do seu MySQL
$pass = '{%M?c=XwHcd-';  // Altere para a senha do seu banco de dados
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Função para enviar o e-mail
function enviarEmail($destinatario, $assunto, $mensagem) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <no-reply@doces.com>" . "\r\n";

    mail($destinatario, $assunto, $mensagem, $headers);
}

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sobremesas = [
        'brigadeiro' => 7.90,
        'Brownie' =>  6.71 ,
        'Pão de Mel ' => 5.18,
        'arroz_doce' => 37.90,
        'beijinho' => 6.90,
        'bombocado' => 10.90,
        'mousse_maracuja' => 7.24,
    ];

    $acompanhamentos = [
        'maria_mole' => 3.90,
        'pe_moleque' => 4.90,
        'acai_tigela' => 29.90,
        'cajuzinho' => 3.90,
        'doce_goiabada' => 19.90,
        'pacoca' => 5.90
    ];

    $bebidas = [
        'refrigerante' => 12.00
    ];

    // Calcular total das sobremesas, acompanhamentos e bebidas
    $total_sobremesas = 0;
    foreach ($sobremesas as $item => $preco) {
        $quantidade = $_POST[$item];
        $total_sobremesas += $quantidade * $preco;
    }

    $total_acompanhamentos = 0;
    foreach ($acompanhamentos as $item => $preco) {
        $quantidade = $_POST[$item];
        $total_acompanhamentos += $quantidade * $preco;
    }

    $total_bebidas = 0;
    foreach ($bebidas as $item => $preco) {
        $quantidade = $_POST[$item];
        $total_bebidas += $quantidade * $preco;
    }

    // Total final
    $total = $total_sobremesas + $total_acompanhamentos + $total_bebidas;

    // Informações do cliente
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $observacoes = $_POST['observacoes'];

    // Enviar e-mail para o cliente
    $email_cliente = $email;
    $assunto_cliente = "Pedido Confirmado";
    $mensagem_cliente = "Olá, $nome! Seu pedido foi confirmado. Segue abaixo os detalhes:\n\n";
    $mensagem_cliente .= "Sobremesas:\n";
    foreach ($sobremesas as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_cliente .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_cliente .= "Acompanhamentos:\n";
    foreach ($acompanhamentos as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_cliente .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_cliente .= "Bebidas:\n";
    foreach ($bebidas as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_cliente .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_cliente .= "\nTotal: R$" . number_format($total, 2, ',', '.') . "\n\n";
    $mensagem_cliente .= "Observações: $observacoes\n\n";
    enviarEmail($email_cliente, $assunto_cliente, $mensagem_cliente);

    // Enviar e-mail para a empresa
    $email_empresa = "ricardosantosanalista@gmail.com";
    $assunto_empresa = "Novo Pedido Recebido";
    $mensagem_empresa = "Novo pedido de $nome:\n\n";
    $mensagem_empresa .= "Sobremesas:\n";
    foreach ($sobremesas as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_empresa .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_empresa .= "Acompanhamentos:\n";
    foreach ($acompanhamentos as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_empresa .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_empresa .= "Bebidas:\n";
    foreach ($bebidas as $item => $preco) {
        if ($_POST[$item] > 0) {
            $quantidade = $_POST[$item];
            $mensagem_empresa .= ucfirst(str_replace("_", " ", $item)) . ": R$" . number_format($preco, 2, ',', '.') . " x $quantidade = R$" . number_format($quantidade * $preco, 2, ',', '.') . "\n";
        }
    }

    $mensagem_empresa .= "\nTotal: R$" . number_format($total, 2, ',', '.') . "\n\n";
    $mensagem_empresa .= "Observações: $observacoes\n\n";
    enviarEmail($email_empresa, $assunto_empresa, $mensagem_empresa);

    // Redirecionar para a página de confirmação
    header("Location: confirmacao.php?total=" . urlencode(number_format($total, 2, ',', '.')));
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - Doces da Lulu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Template Main CSS File -->
  <link href="estilo.css" rel="stylesheet">
  
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Pedido - Doces da Lulu</h1>
    <form action="index.php" method="POST">
        <h3>Sobremesas</h3>
        <?php
        $sobremesas = [
            'brigadeiro' => 7.90,
            'Brownie' => 6.71,
            'Pão de Mel ' => 5.18,
            'arroz_doce' => 37.90,
            'beijinho' => 6.90,
            'bombocado' => 10.90,
            'mousse_maracuja' => 7.24
        ];
        foreach ($sobremesas as $item => $preco) {
            echo "<div class='mb-3'>
                    <label class='form-label'>" . ucfirst(str_replace("_", " ", $item)) . " (R$" . number_format($preco, 2, ',', '.') . ")</label>
                    <input type='number' name='$item' class='form-control' min='0' value='0'>
                   
                  </div>";
        }
        ?>

        <h3>Acompanhamentos</h3>
        <?php
        $acompanhamentos = [
            'maria_mole' => 3.90,
            'pe_moleque' => 4.90,
            'acai_tigela' => 29.90,
            'cajuzinho' => 3.90,
            'doce_goiabada' => 19.90,
            'pacoca' => 5.90
        ];
        foreach ($acompanhamentos as $item => $preco) {
            echo "<div class='mb-3'>
                    <label class='form-label'>" . ucfirst(str_replace("_", " ", $item)) . " (R$" . number_format($preco, 2, ',', '.') . ")</label>
                    <input type='number' name='$item' class='form-control' min='0' value='0'>
                
                  </div>";
        }
        ?>

        <h3>Bebidas</h3>
        <?php
        $bebidas = [
            'refrigerante' => 12.00
        ];
        foreach ($bebidas as $item => $preco) {
            echo "<div class='mb-3'>
                    <label class='form-label'>" . ucfirst(str_replace("_", " ", $item)) . " (R$" . number_format($preco, 2, ',', '.') . ")</label>
                    <input type='number' name='$item' class='form-control' min='0' value='0'>
                    <textarea name='observacoes' class='form-control mt-2' placeholder='Observações'></textarea>
                  </div>";
        }
        ?>

        <h3>Dados do Cliente</h3>
        <div class="mb-3">
            <label class="form-label">Nome Completo</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">CEP</label>
            <input type="text" name="cep" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rua</label>
            <input type="text" name="rua" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
