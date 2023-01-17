<!DOCTYPE html>
<html lang="pt-br">

<head>

    <?php
    require "html/head.php";
    ?>

</head>

<body>
    <?php
    include "html/header.php";
    include_once "src/conexao.php";

    $id = isset($_GET["id"]) ? $_GET["id"] : 0;
    $id_produto = isset($_POST["id_produto"]) ? $_POST["id_produto"] : 0;
    $qtd = isset($_POST["qtd"]) ? $_POST["qtd"] : 0;
    $registro = isset($_POST["registro"]) ? $_POST["registro"] : "";
    $data_registro = isset($_POST["data_registro"]) ? $_POST["data_registro"] : "";
    $valorC = isset($_POST["valor_compra"]) ? $_POST["valor_compra"] : 0;
    $valorV = isset($_POST["valor_venda"]) ? $_POST["valor_venda"] : 0;

    if (isset($_POST["qtd"]) && isset($_POST["valor_compra"])) {
        // echo "info: " . $id_produto . ', ' . $qtd . ', ' . $registro . ', ' . $data_registro . ', ' . $valor;
        $sql_code = "INSERT INTO estoque VALUES (NULL, '$id_produto', '$qtd', '$registro', '$data_registro', '$valorC', '$valorV')";
        $sql_query = $conexao->query($sql_code);
        // var_dump($sql_query);
        if ($sql_query) {
            echo "Gravou!";
        } else {
            echo "Não gravou!";
        }
    }

    $sql_code = "SELECT * FROM produtos LEFT JOIN estoque ON idproduto = id_produto WHERE idproduto = '$id'";
    $sql_query = $conexao->query($sql_code);
    
    $listaProdutos = [];

    if ($sql_query->num_rows > 0) {
        // $produto = $sql_query->fetch_assoc();
        $listaProdutos = $sql_query->fetch_all(MYSQLI_ASSOC);
    }


    ?>

    <main>

        <h1>Estoque</h1>
        <h3>Lista cadastrados</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <!-- <th>ID</th> -->
                    <th width="50">FOTO</th>
                    <th width="200">NOME</th>
                    <th>TIPO</th>
                    <th>CATEGORIA</th>
                    <th>FABRICANTE</th>
                    <th>QTD</th>
                    <th>REGISTRO</th>
                    <th>DATA</th>
                    <th>VALOR COMPRA</th>
                    <th>VALOR VENDA</th>
                </tr>
                <?php
                foreach($listaProdutos as $produto) :
                ?>
                <tr>
                    <!-- <td><?= $produto['idproduto'] ?></td> -->
                    <td><img height="50" src="<?= $produto['foto'] ?>" alt=""></td>
                    <td><?= $produto['nome'] ?></td>
                    <td><?= $produto['tipo'] ?></td>
                    <td><?= $produto['categoria'] ?></td>
                    <td><?= $produto['fabricante'] ?></td>
                    <td><?= $produto['qtd'] ?></td>
                    <td><?= $produto['registro'] ?></td>
                    <td><?= $produto['data_registro'] ?></td>
                    <td><?= $produto['valor_compra'] ?></td>
                    <td><?= $produto['valor_venda'] ?></td>
                </tr>
                <?php
                    endforeach;
                ?>
            </table>
        </div>
        <div class="container-fluid">
            <h3>Registro de Produto</h3>
            <form class="row g-3 container-fluid" action="" method="post">

                <input type="text" class="form-control" id="id_produto" name="id_produto" value="<?= $produto['idproduto'] ?>" hidden>

                <div class="col-md-2 col-sm-12">
                    <label for="qtdid" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="qtdid" name="qtd" value="" required>
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="regid" class="form-label">Registro</label>
                    <select class="form-select" id="regid" name="registro" required>
                        <option selected disabled value="">Selecione</option>
                        <option value="ENTRADA">ENTRADA</option>
                        <option value="SAÍDA">SAÍDA</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12">
                    <label for="dtid" class="form-label">Data</label>
                    <input type="date" class="form-control" id="dtid" name="data_registro" value="" required>
                </div>
                <div class="col-md-3 col-sm-12">
                    <label for="valorid" class="form-label">Valor Compara Unitário</label>
                    <input type="number" class="form-control" id="valorid" name="valor_compra" value="" required tern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="col-md-3 col-sm-12">
                    <label for="valorid" class="form-label">Valor Venda Unitário</label>
                    <input type="number" class="form-control" id="valorid" name="valor_venda" value="" required tern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" id="btn-off" disabled style="display: none">Cadastrar</button>
                    <button class="btn btn-primary" type="submit" id="btn-on">Cadastrar</button>
                </div>
            </form>
        </div>
    </main>

    <?php
    include "html/rodaPe.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>