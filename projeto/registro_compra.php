<!DOCTYPE html>
<html lang="pt-br">

<head>
	<?php require "html/head.php" ?>

</head>

	<body>
		<?php 
        include_once "src/protect.php";
		include "html/header.php";
		include_once "src/model/Produto.php";
		include_once "src/model/Estoque.php";
        include_once "src/conexao.php";

        $id = $_SESSION['id'];

		?>

		<main>
			<h1>Registro de compras</h1>
			<?php 
                if(isset($_SESSION['carrinho'])) : 
            // $sql_code = "SELECT * FROM produtos LEFT JOIN estoque ON idproduto = id_produto WHERE idproduto IN (";
          $sql_code;
		  $lista = []; 
            ?>
			<div class="table-responsive"> 	
				<table class="table table-bordered align-middle">
					<tr>
						<th width="50">FOTO</th>
						<th>NOME</th>
						<th width="80">TIPO</th>
						<th width="100">CATEGORIA</th>
						<th>FABRICANTE</th>
						<th width="50">QTD</th>
						<th>VALOR</th>
						<th>TOTAL</th>
						<th width="60">AÇÃO</th>
					</tr>
					<?php 
					$totalCompra = 0;
					foreach($_SESSION['carrinho'] as $key => $value) :
                        $idDoProduto = unserialize($value['obj'])->getProduto()->getIdProduto();
						$sql_code = "SELECT DISTINCT idproduto, nome, tipo, valor_venda, (SELECT  sum(qtd) FROM produtos LEFT JOIN estoque ON idproduto = id_produto WHERE registro = 'ENTRADA' AND idproduto = '$idDoProduto') - (SELECT  sum(qtd) as saldo FROM produtos LEFT JOIN estoque ON idproduto = id_produto WHERE registro = 'SAÍDA' AND idproduto = '$idDoProduto') as saldo FROM produtos LEFT JOIN estoque ON idproduto = id_produto WHERE idproduto = '$idDoProduto'";

						// echo $sql_code;
                        $sql_query = $conexao->query($sql_code);
            
                        if($sql_query->num_rows > 0){
                            $lista[] = $sql_query->fetch_assoc();
                        }

					?>
					<tr>
						<td><img width="50" src="<?= unserialize($value['obj'])->getProduto()->getFoto() ?>"></td>
						<td><?= unserialize($value['obj'])->getProduto()->getNome() ?></td>
						<td><?= unserialize($value['obj'])->getProduto()->getTipo() ?></td>
						<td><?= unserialize($value['obj'])->getProduto()->getCategoria() ?></td>
						<td><?=  unserialize($value['obj'])->getProduto()->getFabricante() ?></td>
						<td><?= $value['qtd'] ?></td>
						<td><?= number_format($value['valor'], 2, ',','.') ?></td>
						<?php
							$totalProduto = $value['valor'] * $value['qtd'];
							$totalCompra = $totalCompra + $totalProduto;
						?>
						<td><?= number_format($totalProduto, 2, ',','.') ?></td>
						<td>
							<a id="excluir" href="?remover=<?= $key ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Excluir do carrinho">
								<i class="bi bi-trash text-danger" style="font-size: 2rem;"></i>
							</a>
						</td>
					</tr>
					<?php
					endforeach;
                    // $sql_code = substr($sql_code, 0, (strlen($sql_code) -2));
                    // $sql_code = $sql_code . ");";
					?>
					<tr>
						<td colspan="7" style="text-align: center;">TOTAL</td>
						<td colspan="2" class="text-center">R$ <?= number_format($totalCompra, 2, ",", "."); ?></td>
					</tr>
					
				</table>
			</div>
			<?php else :
			echo "<h3 style='text-align: center; margin-top: 50px'>Não há produtos no carrinho no momento.</h3>";
			endif;

            $podeRegistrar = false;
            $texto = "Não possuímos a(s) quantidade(s) do(s) produto(s) solicitado: "; 

            $sql_query = $conexao->query($sql_code);
            $lista = [];
            if($sql_query->num_rows > 0){
                $lista = $sql_query->fetch_all(MYSQLI_ASSOC);
            }

            foreach($lista as $registro){
                $qtdSolicitado = $_SESSION['carrinho'][$registro['idproduto']]['qtd'];
                if($registro['qtd'] > $qtdSolicitado){
					$podeRegistrar = true;
                } else {
					$texto = $texto . "\\n" . $qtdSolicitado . " - " . $registro['nome'];
                    // SQL PARA REGISTRAR NAS 2 TABELAS (ESTOQUE & HISTORICO_COMPRA)
                }
			}
			
			if($podeRegistrar){
				echo "<script> alert('REGISTRADO!'); </script>";
				foreach($lista as $registro){
					 $qtdSolicitado = $_SESSION['carrinho'][$registro['idproduto']]['qtd'];
					$idProduto = $registro['idproduto'];
					$nomeProduto = $registro['nome'];
					$tipo = $registro['tipo'];
					$valor = $registro['valor_venda'];
					$data = date('Y-m-d');

					$sql_code2 = "INSERT INTO estoque VALUES (NULL, '$idProduto', '$qtdSolicitado', 'SAÍDA', '$data', null, '$valor')";

					$sql_query2 = $conexao->query($sql_code2);
					if($sql_query2){
						echo "Gravou!";
					} else {
						echo "Não gravou!";
					}

					$sql_code3 = "INSERT INTO historico_compra VALUES (NULL, '$id', '$data', '$idProduto', '$nomeProduto', '$tipo',  '$valor')";
					$sql_query3 = $conexao->query($sql_code3);
					if($sql_query3){
						echo "Gravou!";
					} else {
						echo "Não gravou!";
					}
				 }

				 unset($_SESSION['carrinho']);
				 echo "<script>window.location.href='historico_compra.php';</script>";
				 
			} else {
				echo "<script> alert('". $texto ."'); </script>";
             }

			?>
			<div style="text-align: center;">
				<a href="produtos.php" type="button" class="btn btn-success btn-lg">Continuar Comprando</a>
				<a href="registro_compra.php" type="button" class="btn btn-primary btn-lg">Finalizar Compras</a>
			</div>
		</main>
<?php
	include "html/rodaPe.php";
?>


		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
		<script>
			const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
		</script>

</body>

</html>