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

	$sql_code = "SELECT * FROM historico_compra WHERE id_cliente = $id";
    $sql_query = $conexao->query($sql_code);

    

	?>

	<main>
        <h1 class="modal-title">Histórico de compras</h1>
        <br>
        <!-- ----------------------------------------------------------------------------------------- -->
        <?php 
        if ($sql_query->num_rows > 0)  : 
            $historico = $sql_query->fetch_all(MYSQLI_ASSOC);
        ?>
        
			<div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr>
                        <!-- <th width="50">FOTO</th> -->
                        <th>ID</th>
                        <th>DATA</th>
                        <th>PRODUTO</th>
                        <th width="80">TIPO</th>
                        <!-- <th width="50">QTD</th> -->
                        <th>VALOR</th>
                        <!-- <th>TOTAL</th>
                        <th width="60">AÇÃO</th> -->
                    </tr>

                    <?php 
                        $totalCompra = 0;
                        foreach($historico as $key => $value) : 
                        // unserialize($value['obj'])->getProduto()->getIdProduto();
                    ?>
                        <tr>
                            <td><?= $value['idhistorico'] ?></td>
                            <td><?= $value['data_compra'] ?></td>
                            <td><?= $value['nome_produto'] ?></td>
                            <td><?= $value['tipo_produto'] ?></td>
                            <td><?= number_format($value['valor'], 2, ',', '.') ?></td>
                            
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    
                </table>
            </div>
            
        <?php else: 
                echo "<h3 style='text-align: center; margin-top: 50px;'>Não há histórico de compras no momento.</h3>";
        ?>
        <?php
            endif;
        ?>
           

        <!-- ----------------------------------------------------------------------------------------- -->
	
    </main>

    <?php
    include "html/rodaPe.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
</body>

</html>