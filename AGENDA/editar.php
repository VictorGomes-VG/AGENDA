<?php
$contatos = [];

foreach ($meusContatos as $cont){
    if ($cont['id'] == $_GET['id']){
        $contatos = $cont;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #292929">

    <div class="container" style="margin-top: 30px; margin-bottom: 30px; border-radius: 10px; background-color: #000; color: #ffffff;">
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline" action="controlador_agenda.php?acao=editar1&id=<?= $_GET['id']?>" method="post">

                    <!--nome-->
                    <div class="form-group col-md-12" style="text-align: center">
                        <label for="nome">Nome</label> <br>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $contatos['nome'] ?>">
                    </div>
                    <br>
                    <!--email-->
                    <div class="form-group col-md-12" style="text-align: center">
                        <label for="email">Email</label> <br>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $contatos['email'] ?>">
                    </div>
                    <br>
                    <!--telefone-->
                    <div class="form-group col-md-12" style="text-align: center">
                        <label for="telefone">Telefone</label> <br>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $contatos['telefone'] ?>">
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary form-group" style="float: right">EDITAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>