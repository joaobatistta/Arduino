<?php
// Configuração de conexão com o banco de dados
$servername = "localhost";
$username = "root";  // Usuário padrão no XAMPP
$password = "";      // Senha padrão no XAMPP
$dbname = "controle_financeiro"; // Nome do banco de dados

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Adicionar pacote
if (isset($_POST['adicionar_pacote'])) {
    $preco_final = $_POST['preco_final'];
    $custo_equipamentos = $_POST['custo_equipamentos'];
    $custo_instalacao = $_POST['custo_instalacao'];
    $nome_pacote = $_POST['nome_pacote'];

    // Calcular margem de lucro (40% de lucro sobre o custo total)
    $custo_total = $custo_equipamentos + $custo_instalacao;
    $lucro_liquido = 0.35 * $custo_total;
    $lucro_pessoal = 0.50 * $lucro_liquido;
    $reinvestimento = 0.30 * $lucro_liquido;
    $fundo_emergencia = 0.20 * $lucro_liquido;



// Calcular margem de lucro percentual
$margem_lucro = ($lucro_liquido / $preco_final) * 100;

// Inserir os dados no banco de dados
$sql = "INSERT INTO controle_financeiro (preco_final, custo_equipamentos, custo_instalacao, lucro_liquido, lucro_pessoal, reinvestimento, fundo_emergencia, margem_lucro, nome_pacote)
        VALUES ('$preco_final', '$custo_equipamentos', '$custo_instalacao', '$lucro_liquido', '$lucro_pessoal', '$reinvestimento', '$fundo_emergencia', '$margem_lucro', '$nome_pacote')";


    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert success'>Pacote adicionado com sucesso!</div>";
    } else {
        die("<div class='alert error'>Erro ao adicionar pacote: " . $conn->error . "</div>");
    }
}

// Buscar o pacote mais recente
$sql = "SELECT * FROM controle_financeiro ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if (!$result) {
    die("<div class='alert error'>Erro na consulta SQL: " . $conn->error . "</div>");
}


// Calcular distribuição do lucro
if (!isset($lucro_liquido) || $lucro_liquido <= 0) {
    echo "<tr><td colspan='3'>Erro: Lucro líquido não pode ser calculado.</td></tr>";
} else {
    $lucro_pessoal = 0.50 * $lucro_liquido;
    $reinvestimento = 0.30 * $lucro_liquido;
    $fundo_emergencia = 0.20 * $lucro_liquido;

}


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Financeiro</title>
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
            flex-direction: column;

        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 900px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .section {
            margin-top: 30px;
        }
        .section h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        td {
            text-align: right;
        }
        .highlight {
            font-weight: bold;
            color: #2d7c9f;
        }
        .alert {
            padding: 15px;
            background-color: #e9f7f7;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .clear-history {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .clear-button {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 30px; /* Distância entre o botão e o conteúdo acima */
    width: 100%; /* Faz com que o botão ocupe toda a largura disponível */
    text-align: center;
}

.clear-button:hover {
    background-color: #d32f2f;
}
.container {
    padding-bottom: 30px; /* Espaço para o botão */
}
 /* Responsividade */
 @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .submit-button {
                width: 100%;
            }
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Controle Financeiro</h2>

        <div class="section">
            <h3>Adicionar Novo Pacote</h3>
            <form method="POST">
                <input class="input-field" type="text" name="nome_pacote" placeholder="Nome do Pacote" required><br>
                <input class="input-field" type="number" step="0.01" name="preco_final" placeholder="Preço final do pacote (R$)" required><br>
                <input class="input-field" type="number" step="0.01" name="custo_equipamentos" placeholder="Custo dos equipamentos (R$)" required><br>
                <input class="input-field" type="number" step="0.01" name="custo_instalacao" placeholder="Custo da instalação (R$)" required><br>
                <button class="submit-button" type="submit" name="adicionar_pacote">Adicionar Pacote</button>
            </form>
        </div>

        <?php
// Exibir os pacotes e seus relatórios
$sql = "SELECT * FROM controle_financeiro ORDER BY id DESC LIMIT 1";  // Pegue apenas o pacote mais recente
$result = $conn->query($sql);
?>

<div class="section">
    <h3>Distribuição do Valor do Pacote</h3>
    <table>
        <tr>
            <th>Item</th>
            <th>Valor (R$)</th>
            <th>% do Total</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $preco_final = $row['preco_final'];
            $custo_equipamentos = $row['custo_equipamentos'];
            $custo_instalacao = $row['custo_instalacao'];

            // Calcular o lucro líquido como 40% do custo total
            $custo_total = $custo_equipamentos + $custo_instalacao;
            $lucro_liquido = 0.35 * $custo_total;

            // Calcular o total (soma de equipamentos + instalação + lucro)
            $total = $custo_equipamentos + $custo_instalacao + $lucro_liquido;

            // Calcular percentuais
            $percent_equipamentos = ($custo_equipamentos / $total) * 100;
            $percent_instalacao = ($custo_instalacao / $total) * 100;
            $percent_lucro = ($lucro_liquido / $total) * 100;

            // Exibir os valores
            echo "<tr><td>Preço Final</td><td>" . number_format($preco_final, 2, ',', '.') . "</td><td>" . number_format(($preco_final / $total) * 100, 2, ',', '.') . "%</td></tr>";
            echo "<tr><td>Custo dos Equipamentos</td><td>" . number_format($custo_equipamentos, 2, ',', '.') . "</td><td>" . number_format($percent_equipamentos, 2, ',', '.') . "%</td></tr>";
            echo "<tr><td>Custo da Instalação</td><td>" . number_format($custo_instalacao, 2, ',', '.') . "</td><td>" . number_format($percent_instalacao, 2, ',', '.') . "%</td></tr>";
            echo "<tr><td>Lucro Líquido</td><td>" . number_format($lucro_liquido, 2, ',', '.') . "</td><td>" . number_format($percent_lucro, 2, ',', '.') . "%</td></tr>";
            echo "<tr><td>Total</td><td>" . number_format($total, 2, ',', '.') . "</td><td>100%</td></tr>";
        } else {
            echo "<tr><td colspan='3'>Nenhum pacote registrado ainda.</td></tr>";
        }
        ?>
    </table>
</div>
<div class="section">
    <h3>Distribuição do Lucro</h3>
    <table>
        <tr>
            <th>Destino do Lucro</th>
            <th>Valor (R$)</th>
            <th>% do Lucro</th>
        </tr>
        <tr>
            <td>Seu pagamento pessoal</td>
            <td><?php echo number_format($lucro_pessoal, 2, ',', '.'); ?></td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Reinvestimento</td>
            <td><?php echo number_format($reinvestimento, 2, ',', '.'); ?></td>
            <td>30%</td>
        </tr>
        <tr>
            <td>Fundo Emergencial</td>
            <td><?php echo number_format($fundo_emergencia, 2, ',', '.'); ?></td>
            <td>20%</td>
        </tr>
    </table>
</div>


        
    </table>
</div>
<div class="section">
    <form method="POST">
        <!-- Alterei o type de submit para button e adicionei a função limparTabelas() no evento onclick -->
        <button class="clear-button" type="button" onclick="limparTabelas()">Limpar Histórico de Pacotes</button>
    </form>
</div>

    <script>
        // Função para limpar as duas tabelas
function limparTabelas() {
    // Limpa as tabelas de Distribuição do Valor do Pacote e Distribuição do Lucro
    let tabelas = document.querySelectorAll('table');
    
    // Limpar a primeira tabela (Distribuição do Valor do Pacote)
    let tabelaPacote = tabelas[0];
    let rowsPacote = tabelaPacote.querySelectorAll('tr');
    rowsPacote.forEach(function(row, index) {
        // Ignorar a primeira linha (cabeçalho da tabela)
        if (index > 0) {
            row.querySelectorAll('td').forEach(function(td) {
                td.textContent = ''; // Limpa o conteúdo da célula
            });
        }
    });

    // Limpar a segunda tabela (Distribuição do Lucro)
    let tabelaLucro = tabelas[1];
    let rowsLucro = tabelaLucro.querySelectorAll('tr');
    rowsLucro.forEach(function(row, index) {
        // Ignorar a primeira linha (cabeçalho da tabela)
        if (index > 0) {
            row.querySelectorAll('td').forEach(function(td) {
                td.textContent = ''; // Limpa o conteúdo da célula
            });
        }
    });
}
window.onload = function() {
        limparTabelas();
    }

    </script>

</body>


</html>

<?php
// Fechar a conexão
$conn->close();
?>