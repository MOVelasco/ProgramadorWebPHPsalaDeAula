<!DOCTYPE html>
<html lang="pt-br">

<head>

	<?php
		require "html/head.php";
		?>

</head>

<body>
	<?php
	require_once "src/protect.php";
	require_once "src/conexao.php";
	require_once "html/header.php";

	if (isset($_SESSION['id'])){
		$id = $_SESSION['id'];
	}

	$sql_code = "SELECT * FROM cliente LEFT JOIN endereco AS e ON e.id_cliente = idcliente LEFT JOIN contatos AS c ON c.id_cliente = idcliente WHERE idcliente = $id";
    $sql_query = $conexao->query($sql_code);

    if ($sql_query->num_rows > 0) {
        // $clienteCompleto = $sql_query->fetch_all(MYSQLI_ASSOC);
		$clienteCompleto = $sql_query->fetch_assoc();

		// var_dump($clienteCompleto);
    }

	?>

	<main>

		<!-- <button type="button" class="btn btn-primary"> -->
            <a href="#">
                <i class="bi bi-person-gear" style='font-size: 2rem;'></i>
            </a>
            
		<!-- 
		<i class='bi bi-plus-circle text-success' style='font-size: 2rem;'></i>
		<i class="bi bi-person-gear text-danger" style='font-size: 2rem;'></i>
		<i class="bi bi-table" style='font-size: 2rem;'></i>
		<i class="bi bi-telephone" style='font-size: 2rem;'></i>
		<i class="bi bi-trash" style='font-size: 2rem;'></i>
		 -->
        <!-- </button> -->

        <div class="row row-cols-1 row-cols-md-3 g-4">
			
            <div class="col">
				<a href="edicaoCliente.php?id=<?= $id; ?>" class="linkCustomizado">
                <div class="card">
                    <!-- <img src="" class="card-img-top fotoProduto" alt="processador"> -->
                    <i class="bi bi-person-square text-primary text-center" style='font-size: 10rem;'></i>
                    <div class="card-body">
                        <h5 class="card-title text-center" >Dados Pessoais</h5>
                        <!-- <p class="card-text"><?= substr($produto['descricao'], 0, 100) ?>...</p>
                        <a href="mais_detalhes.php?id=<?= $produto['idproduto'] ?>" class="btn btn-primary">Mais detalhes</a> -->
                    </div>
                </div>
				</a>
            </div>
			
			<a href="cadastroClienteComplemento.php?aba=endereco" class="linkCustomizado <?= ($clienteCompleto["logradouro"] != '') ? 'text-primary' : 'text-danger' ?>">
			<div class="col">
				<div class="card">
						<i class="bi bi-house text-center" style='font-size: 10rem;'></i>
					<div class="card-body">
						<h5 class="card-title text-center">Endereço</h5>
						<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a> -->
					</div>
				</div>
			</div>
			</a>
			
			<a href="cadastroClienteComplemento.php?aba=contato" class="linkCustomizado <?= ($clienteCompleto["descricao"] != '') ? 'text-primary' : 'text-danger' ?>">
			<div class="col">
				<div class="card">
						<i class="bi bi-telephone text-center" style='font-size: 10rem;'></i>
					<div class="card-body">
						<h5 class="card-title text-center">Contatos</h5>
						<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a> -->
					</div>
				</div>
			</div>
			</a>
			
			<a href="historico_compra.php" class="linkCustomizado <?= ('' == '') ? 'text-primary' : 'text-danger' ?>">
			<div class="col">
				<div class="card">
						<i class="bi bi-table text-center" style='font-size: 10rem;'></i>
					<div class="card-body">
						<h5 class="card-title text-center">Histórico de compras</h5>
						<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a> -->
					</div>
				</div>
			</div>
			</a>

		</div>
	</main>

	<?php
	include "html/rodaPe.php";
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>