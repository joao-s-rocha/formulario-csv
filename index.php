<?php
//index.php

$error = '';
$name = '';
$sobrenome = '';
$cep = '';
$telefone = '';
$data_nascimento = '';

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{
    if(empty($_POST["name"]))
    {
        $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
    }
    else
    {
        $name = clean_text($_POST["name"]);
        if(!preg_match("/^[a-zA-Z ]*$/",$name))
        {
            $error .= '<p><label class="text-danger">Apenas letras e espaços em brancos permitidos</label></p>';
        }
    }

    if(empty($_POST["sobrenome"]))
    {
        $error .= '<p><label class="text-danger">Por favor insira seu sobrenome</label></p>';
    }
    else
    {
        $sobrenome = clean_text($_POST["sobrenome"]);
        if(!preg_match("/^[a-zA-Z ]*$/",$sobrenome))
        {
            $error .= '<p><label class="text-danger">Apenas letras e espaços em brancos permitidos</label></p>';
        }
    }

    if(empty($_POST["cep"]))
    {
        $error .= '<p><label class="text-danger">É necessário informar um CEP</label></p>';
    }
    else
    {
        $cep = clean_text($_POST["cep"]);
    }

    if(empty($_POST["telefone"]))
    {
        $error .= '<p><label class="text-danger">É necessário informar um telefone</label></p>';
    }
    else
    {
        $telefone = clean_text($_POST["telefone"]);
        if(!preg_match("/^[0-99999999999]*$/",$telefone))
        {
            $error .= '<p><label class="text-danger">Apenas números são permitidos</label></p>';
        }
    }

    if(empty($_POST["data_nascimento"]))
    {
        $error .= '<p><label class="text-danger">É necessário informar uma data de nascimento</label></p>';
    }
    else
    {
        $data_nascimento = clean_text($_POST["data_nascimento"]);
    }

    if($error == '')
    {
    $file_open = fopen("pessoa.csv", "a");
    $no_rows = count(file("pessoa.csv"));

        if($no_rows > 1)
        {
            $no_rows = ($no_rows - 1) + 1;
        }

        $form_data = array(
            'sr_no'  => $no_rows,
            'name'  => $name,
            'sobrenome'  => $sobrenome,
            'cep' => $cep,
            'telefone' => $telefone,
            'data_nascimento'  => $data_nascimento
        );
        fputcsv($file_open, $form_data);
        $error = '<label class="text-success">Obrigado!</label>';
        $name = '';
        $sobrenome = '';
        $cep = '';
        $telefone = '';
        $data_nascimento = '';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro simples para csv</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <br />
        <div class="container">
            <h2 align="center">Por favor faça seu cadastro</h2>
            <br />
            <div class="col-md-6" style="margin:0 auto; float:none;">
                <form method="post">
                    <h3 align="center">Formulário</h3>
                    <br />
                    <?php echo $error; ?>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" placeholder="Insira seu nome" class="form-control" value="<?php echo $name; ?>" />
                    </div>    
                    
                    <div class="form-group">
                        <label>Sobrenome</label>
                        <input type="text" name="sobrenome" class="form-control" placeholder="Insira seu sobrenome" value="<?php echo $sobrenome; ?>" />
                    </div>

                    <div class="form-group">
                        <label>Cep</label>
                        <input type="text" name="cep" class="form-control" placeholder="CEP" value="<?php echo $cep; ?>" />
                    </div>

                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control" placeholder="Insira seu telefone" value="<?php echo $telefone; ?>" />
                    </div>

                    <div class="form-group">
                        <label>Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control" placeholder="Data de nascimento" value="<?php echo $data_nascimento; ?>" />
                    </div>

                    <div class="form-group" align="center">
                        <input type="submit" name="submit" class="btn btn-info" value="Submit" />
                    </div>

                    <div class="form-group" align="center">
                        <a href="exibe.php">Exibir Dados</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>