<?php
require_once 'pessoa.php';
$p = new Pessoa("crudpdo","localhost","root","");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
<?php
        if(isset($_POST['nome']))
        {
            if(isset($_GET['id_up']) && !empty($_GET['id_up']))
            {
                $id_upd = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                if (!empty($nome) && !empty($telefone) && !empty($email))
                {
    
                    $p->atualizarDados($id_upd, $nome, $telefone, $email);
                        header("location: index.php");
                    
    
                } else {
                    echo "Preencha todos os campos";
                }
            }
        }
    ?>
    <?php
        if(isset($_GET['id_up']))
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update); 
        }
    
    
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];}?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">

            <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
        </form>
    </section>
    <section id="direita">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th colspan="2">Email</th>
            </tr>
        </thead>
        <?php
            $dados = $p->buscarDados();
            if(count($dados) > 0)
            {
                for ($i=0; $i < count($dados); $i++) 
                {
                    echo "<tbody> <tr>";
                    foreach ($dados[$i] as $k => $v) 
                    {
                        if($k != "id")
                        {
                            echo "<td>".$v."</td>";
                        }
                    }
                    ?>
                    <td>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                        <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                    </td>
                    <?php
                    echo "</tr> </tbody>";
                }
            }
            else {
                echo "Ainda não há pessoas cadastradas!";
            }
        ?>
            </tr>
        </tbody>
    </table>
    </section>
    
</body>
</html>

<?php

    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }

?>