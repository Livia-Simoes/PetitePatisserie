
<?php

// Inicia a sessão se ela ainda não tiver sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<header class="header-container">

    <!-- Logotipo redondo centralizado com o nome -->
    <div class="brand-header">

        <img src="/petite_patisserie/assets/imagens/logo.png"
             alt="Petite Patisserie Logo"
             class="brand-logo-round">

        <h1 class="brand-title">Petite Patisserie</h1>

    </div>

    <!-- Navegação em pílulas decoradas -->
    <nav class="navbar-cute">

        <!-- Link para a página inicial -->
        <a href="/petite_patisserie/index.php" class="nav-link">Início</a>

        <?php if (isset($_SESSION["usuario"])): ?>

            <!-- Links disponíveis para usuários logados -->
            <a href="/petite_patisserie/app/select.php" class="nav-link">Vitrine</a>

            <a href="/petite_patisserie/app/select_w.php" class="nav-link">Pesquisar</a>

            <a href="/petite_patisserie/app/carrinho.php" class="nav-link">Carrinho</a>

            <a href="/petite_patisserie/contato.php" class="nav-link">Contato</a>

            <!-- Links exclusivos do administrador -->
            <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"): ?>

                <!-- Cadastrar novo produto -->
                <a href="/petite_patisserie/app/cadastrar_produto.php" class="nav-link admin-link">
                    Adicionar produto
                </a>

                <!-- Atualizar cliente -->
                <a href="/petite_patisserie/app/atualizar_usuario.php" class="nav-link admin-link">
                    Atualizar cliente
                </a>

                <!-- Atualizar produto -->
                <a href="/petite_patisserie/app/atualizar_produtos.php" class="nav-link admin-link">
                    Atualizar produto
                </a>

                <!-- Deletar cliente -->
                <a href="/petite_patisserie/app/apagar_usuario.php" class="nav-link admin-link">
                    Deletar cliente
                </a>

                <!-- Deletar produto -->
                <a href="/petite_patisserie/app/apagar_produto.php" class="nav-link admin-link">
                    Deletar produto
                </a>

            <?php endif; ?>

            <!-- Sair da conta -->
            <a href="/petite_patisserie/login/logout.php" class="nav-link logout-link">
                Sair
            </a>

        <?php else: ?>

            <!-- Login do cliente -->
            <a href="/petite_patisserie/login/login_cliente.php" class="nav-link">
                Entrar
            </a>

            <!-- Cadastro de cliente -->
            <a href="/petite_patisserie/app/cadastro_cliente.php" class="nav-link nav-highlight">
                Cadastrar
            </a>

            <!-- Contato -->
            <a href="/petite_patisserie/contato.php" class="nav-link">
                Contato
            </a>

        <?php endif; ?>

    </nav>

</header>
