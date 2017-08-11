<?php
                                                                                                                      //
if(!isset($_SESSION)){                                                           //VERIFICA SE HÁ UMA SESSION EXISTENTE;
    session_start();                                                                              //SE NÃO HÁ ,É CRIADA;
}                                                                                                                     //
if (!isset($_GET['acao'])){                                                            //VERIFICA SE EXISTE O GET'ACAO';
    $_GET['acao'] = null;                                             //SE NÃO EXISTIR O GET'ACAO'ATRIBUI NULL PARA ELE;
}                                                                                                                     //
                                                                                                                      //
function login($login, $senha){                                                                                       //
    $lista_usuarios =json_decode(file_get_contents("data_bases/users.json"), true);//PEGA OS ARQUIVOS DO 'USERS.JSON E..
                                                                                             //E TRANSFORMA EM UM ARRAY;
    foreach ($lista_usuarios as $user){                                                          //PERCORRE OS CONTATOS;
                                                                                                                      //
        if($login == $user['login'] and $senha == $user['senha']){    //VERIFICA SE O USUARIO E A SENHA SAO IGUAIS A ...
                                                                                          //POSIÇÃO DO ARRAY PERCORRIDO;
            $_SESSION['login']       = $user['login'];                     //ARMAZENA EM UMA SESSION O LOGIN DO USUARIO;
            $_SESSION['nome']        = $user['nome'];                       //ARMAZENA EM UMA SESSION O NOME DO USUARIO;
            $_SESSION['esta_logado'] = true;                           //ARMAZENA EM UMA SESSION A VERIFICAÇÃO DO LOGIN;
                                                                                                                      //
            header("Location: index.php");                                               //DIRECIONA PARA O 'INDEX.PHP';
                                                                                                                      //
        }                                                                                                             //
    }                                                                                                                 //
                                                                                                                      //
    if (!$_SESSION['esta_logado']) {                                                  //VERIFICA SE O LOGIN ESTA LOGADO;
                                                                                                                      //
        $_SESSION['login'] = $login;                               //ARMAZENA EM UMA SESSION O USUARIO INSERIDO NO FORM;
        header("Location: login.php");                                                       //REDIRICIONA PARA O LOGIN;
    }                                                                                                                 //
}                                                                                                                     //
                                                                                                                      //
function logout(){                                                                                                    //
    session_destroy();                      //DESTROY A SESSION FAZENDO COM QUE A VERIFICAÇAO DO USUARIO SE TORNE FALSA;
                                                                                                                      //
    header("Location: login.php");                                                     //REDIRECIONA PARA O 'LOGIN.PHP';
}                                                                                                                     //
                                                                                                                      //
function cadastrarUser($nome, $login, $senha){                                                                        //
    $lista_usuarios =json_decode(file_get_contents("data_bases/users.json"), true);                                   //
                                                                                                                      //
    $lista_usuarios[] = array(                                      //NA PROXIMA POSIÇÃO VAZIA ARMAZENA UM ARRAY COM ..;
        'nome'     => $nome,                                                                                  //UM NOME;
        'login'    => $login,                                                                                //UM LOGIN;
        'senha'    => $senha                                                                              //E UMA SENHA;
    );                                                                                                                //
                                                                                                                      //
    $_SESSION['login'] = $login;                                                      //ARMAZENA EM UMA SESSION O LOGIN;
                                                                                                                      //
    file_put_contents('data_bases/users.json', json_encode($lista_usuarios, JSON_PRETTY_PRINT));                      //
                                                                                                                      //
    header("Location: login.php");                                                     //REDIRECIONA PARA O 'LOGIN.PHP';
}                                                                                                                     //
                                                                                                                      //
function cadastrarContatos ($user, $nome, $email, $telefone){                                                         //
                                                                                                                      //
    $contatos = json_decode(file_get_contents("data_bases/contatos.json"), true);                                     //
                                                                                                                      //
    $contatos[] = [                                                 //NA PROXIMA POSIÇÃO VAZIA ARMAZENA UM ARRAY COM ..;
        'nome'     => $nome,                                                                                  //UM NOME;
        'email'    => $email,                                                                                //UM EMAIL;
        'telefone' => $telefone,                                                                          //UM TELEFONE;
        'id'       => uniqid(),                                                                                //UMA ID;
        'user'     => $user                                                                           //E O LOGIN ATUAL;
    ];                                                                                                                //
                                                                                                                      //
    file_put_contents('data_bases/contatos.json', json_encode($contatos, JSON_PRETTY_PRINT));                         //
                                                                                                                      //
    header("Location: index.php");                                                     //REDIRECIONA PARA O 'INDEX.PHP';
                                                                                                                      //
}                                                                                                                     //
                                                                                                                      //
function exclui ($id, $user){                                                                                         //
    $contatos = json_decode(file_get_contents("data_bases/contatos.json"), true);// PUXA OS ARQUIVOS E TRANFORMA EM UM..
                                                                                                                //ARRAY;
    $contatosExclui = [];                                                            //A VARIAVEL RECEBE UM ARRAY VAZIO;
                                                                                                                      //
    foreach ($contatos as $cont){                                                        //PERCORRE O ARRAY DE CONTATOS;
        if ($cont['id'] != $id){                                   //SE O ID FOR DIFERENTE AO ID PASSADO COMO PARAMETRO;
            $contatosExclui[] = $cont;                              //VOCÊ ARMAZENA APENAS OS CONTATOS DIFERENTES DO ID;
        }                                                                                                             //
    }                                                                                                                 //
                                                                                                                      //
    $contatoJson = json_encode($contatosExclui, JSON_PRETTY_PRINT);                                                   //
                                                                                                                      //
    file_put_contents('data_bases/contatos.json', $contatoJson);                                                      //
                                                                                                                      //
    header("Location: index.php");                                              //REDIRICIONA PARA A PAGINA 'INDEX.PHP';
}                                                                                                                     //
                                                                                                                      //
function editar ($id, $user, $nome, $email, $telefone){
    $contatosEditar = [];

    $contatos = json_decode(file_get_contents("data_bases/contatos.json"), true);

    foreach ($contatos as $cont){

        if ($cont['id'] != $id){
            $contatosEditar[] = $cont;
        } else {
            $contatosEditar[] = array(
                'nome'     => $nome,
                'email'    => $email,
                'telefone' => $telefone,
                'id'       => $id,
                'user'     => $user
            );
        }
    }

    $contatoJson = json_encode($contatosEditar, JSON_PRETTY_PRINT);

    file_put_contents('data_bases/contatos.json', $contatoJson);

    header("Location: index.php");
} //Checked***

function buscar ($user, $busca){
    $meusContatos = pegarcontatos($user);

    $contatos = [];

    $countBusca = strlen($busca);

    foreach ($meusContatos as $contato) {
        $countContato = strlen($contato["nome"]);
        $j = $countContato;
        $verificaId = true;

        for ($i = $countBusca; $i > 1; $i--){

            $cont = str_split($contato["nome"], $j)[0];
            $letra = str_split($busca, $i)[0];

            if (strtolower(str_replace(" ", "", $letra)) == strtolower(str_replace(" ", "", $cont))){

                foreach ($contatos as $contatosBuscados){

                    if ($contatosBuscados["id"] == $contato["id"]){
                        $verificaId = false;
                        break;
                    }
                }
                if ($verificaId){
                    $contatos[] = $contato;
                    break;
                }

            }

            if ($countBusca >= $countContato){
                if ($i <= $j and $j > 1){
                    $j--;
                }
            } elseif ($countBusca < $countContato and $i < $j){
                $i = $countBusca;
                $j--;
            }
        }
    }

    return $contatos;
} //Checked***

function pegarcontatos($user){
    $contatos = json_decode(file_get_contents("data_bases/contatos.json"), true);
    $contatosUser = [];

    foreach ($contatos as $contato){
        if ($contato['user'] == $user){
            $contatosUser[] = $contato;
        }
    }

    return $contatosUser;
} //Checked***

switch ($_GET['acao']){
    case 'login':
        login($_POST['login'], $_POST['senha']);
        break;

    case 'logout':
        logout();
        break;

    case 'cadastrarContatos':
        cadastrarContatos($_SESSION['login'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
        break;

    case 'cadastraUser':
        cadastrarUser($_POST['nome'], $_POST['login'], $_POST['senha']);
        break;

    case 'editar1':
        editar($_GET['id'], $_SESSION['login'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
        break;

    case 'exclui':
        exclui($_GET['id'], $_SESSION['login']);
        break;

    case 'buscar':
        $contatos = buscar($_SESSION['login'],$_POST['busca']);
        break;

}
//ROTAS