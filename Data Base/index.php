<?php
include('config.php');

if (isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $sql = "INSERT INTO produtos (nome, preco, quantidade) VALUES ('$nome', '$preco', '$quantidade')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert success'>Produto adicionado com sucesso!</div>";
    } else {
        echo "<div class='alert error'>Erro: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

if (isset($_POST['retirar'])) {
    $id = $_POST['id'];
    $quantidade = $_POST['quantidade'];

    $sql = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert success'>Produto retirado com sucesso!</div>";
    } else {
        echo "<div class='alert error'>Erro: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], input[type="number"][step] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .alert {
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        h3 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Controle de Estoque</h2>

        <h3>Adicionar Produto ao Estoque</h3>
        <form method="post">
            <input type="text" name="nome" placeholder="Nome do Produto" required><br>
            <input type="number" step="0.01" name="preco" placeholder="Preço do Produto" required><br>
            <input type="number" name="quantidade" placeholder="Quantidade" required><br>
            <button type="submit" name="adicionar">Adicionar</button>
        </form>

        <h3>Retirar Produto do Estoque</h3>
        <form method="post">
            <input type="number" name="id" placeholder="ID do Produto" required><br>
            <input type="number" name="quantidade" placeholder="Quantidade a Retirar" required><br>
            <button type="submit" name="retirar">Retirar</button>
        </form>

        <h3>Lista de Produtos no Estoque</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
            </tr>
            <?php
            $sql = "SELECT * FROM produtos";
            $result = $conn->query($sql);

            $valorTotalEstoque = 0; // Variável para armazenar o valor total do estoque

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $valorTotalProduto = $row['preco'] * $row['quantidade']; // Calcula o valor total do produto
                    $valorTotalEstoque += $valorTotalProduto; // Soma ao valor total do estoque
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nome'] . "</td><td>" . number_format($row['preco'], 2, ',', '.') . "</td><td>" . $row['quantidade'] . "</td><td>" . number_format($valorTotalProduto, 2, ',', '.') . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum produto encontrado</td></tr>";
            }
            ?>
        </table>

        <h3>Valor Total do Estoque: R$ <?php echo number_format($valorTotalEstoque, 2, ',', '.'); ?></h3>
    </div>

</body>
</html>
