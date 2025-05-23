
<?php
if (isset($_GET['total'])) {
    $total = $_GET['total'];
} else {
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Pedido Realizado com Sucesso</h1>
    <p class="text-center">Total: R$ <?= $total ?></p>
    <p class="text-center">Obrigado por escolher Doces da Lulu! Verifique seu e-mail!</p>
<center>
	<a href="https://docesdalulu.com.br.informaticaweb.top/" class="btn btn-sm btn-primary">Voltar</a> </center>
	
	
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
