<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Navegação Responsivo</title>
    <style>
       /* Centraliza o conteúdo na tela */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('https://i.pinimg.com/736x/a2/3a/c9/a23ac93734beb9407148dd04502de69a.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
    color: #fff;
}

/* Caixa centralizada */
.content {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 800px;
}

/* Estilo do menu */
nav {
    margin-bottom: 20px;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

li {
    margin: 10px;
}

a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    padding: 8px 15px; /* Reduz a largura do botão */
    background-color: #333;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: inline-block;
    min-width: 120px;
    text-align: center;
}

a:hover {
    background-color: #575757;
    transform: scale(1.1);
}

/* Título e conteúdo */
h2 {
    margin-top: 0;
    color: #333;
    font-size: 40px;
}

p {
    color: #555;
    font-size: 22px;
}

/* 📌 Responsividade para telas menores */
@media (max-width: 768px) {
    body {
        height: 100vh; /* Garante que o conteúdo fique no centro */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .content {
        width: 90%;
        padding: 20px;
    }

    h2 {
        font-size: 32px;
    }

    p {
        font-size: 18px;
    }

    ul {
        flex-direction: column;
        align-items: center;
    }

    li {
        margin: 5px 0;
    }

    a {
        font-size: 16px;
        padding: 6px 12px;
        min-width: 100px;
    }
}

    </style>
</head>
<body>

    <div class="content">
        <h2>Tech Solutions</h2>
        <p>Simplificando Sua Vida com Inovação!</p>

        <nav>
            <ul>
                <li><a href="index.php">Produtos e Estoque</a></li>
                <li><a href="controle_financeiro.php">Controle Financeiro</a></li>
            </ul>
        </nav>
    </div>

</body>
</html>
