<?php

$currentUser;

$totalSales = 0;

$isLoggedIn = (bool) false;

$dataBase = [];
$dataBase["admin"] = '12345'; // Usuário teste;


function login() {
    $user = readline("User: \n");
    $password = readline("Senha: \n");
    userValidation($user, $password);
}

function productSales () {
    global $currentUser;
    global $totalSales;

    system("clear");

    $productName = readline("Nome do Produto: \n");
    $price = readline("Preço: \n");

    $totalSales += $price;

    $message = $currentUser . "      Venda (Produto): " . $productName . "    Preço: R$:" . $price . "    ". date('d/m/Y H:i:s') . " \n";
    file_put_contents('usuarios.txt', $message, FILE_APPEND);

    system("clear");
};

function newUser () {
    global $dataBase;

    system("clear");
    
    $name = readline("Name: \n");
    $password = readline("Senha: \n");
    $confirmPassword = readline("Confirmar Senha: \n");
    
    if ($confirmPassword == $password) {
        $dataBase[$name] = $password;
        $message = "Usuário $name criado em:   " . date('d/m/Y H:i:s') . " \n";
        file_put_contents('usuarios.txt', $message, FILE_APPEND);
        system("clear");
        
    } else {
        echo "------------------------------- \n";
        echo "Senhas não coincidem! \n";
        echo "------------------------------- \n";
        readline("Aperte Enter para criar um conta! \n");
        system("clear");
        newUser();
    };
};

function history() {
    system("clear");
    global $totalSales;

    echo "------------------------------- \n";
    echo "Histórico de vendas \n";
    echo "------------------------------- \n";
    $conteudo = file_get_contents("usuarios.txt");
    echo nl2br($conteudo);
    echo "------------------------------- \n";
    echo "Total de vendas: R$:$totalSales \n";
    echo "------------------------------- \n";
    
    readline("Aperte Enter para voltar ao menu. \n");
};

function disconnected () {
    global $isLoggedIn;
    global $currentUser;

    $message = "Usuário $currentUser deslogado em:   " . date('d/m/Y H:i:s') . " \n";
    file_put_contents('usuarios.txt', $message, FILE_APPEND);

    $isLoggedIn = false;
}

function userValidation ($user, $password) {
    global $isLoggedIn;
    global $dataBase;
    global $currentUser;

    if (isset($dataBase[$user])) {
        if($dataBase[$user] == $password) {
            $currentUser = $user; 

            $message = "Usuário $currentUser logado em:   " . date('d/m/Y H:i:s') . " \n";
            file_put_contents('usuarios.txt', $message, FILE_APPEND);

            $isLoggedIn = true;
        } else {
            system("clear");
            echo "------------------------------- \n";
            echo "Senha incorreta! \n";
            echo "------------------------------- \n";
            login();
        }
    } else {
        system("clear");
        echo "------------------------------- \n";
        echo "Usuario não encontrado! \n";
        echo "------------------------------- \n";
        login();
    }
}

function validationForLoggedOutUser ($num) {
    if ($num == 1) {
        login();
        system('clear');
    } else {
        system('clear');
        echo "------------------------------- \n";
        echo "Opção inválida! \n";
    };
};

function menu ($num) {

    switch ($num) {
        case "1":
            productSales();
            break;
        case "2":
            newUser();
            break;
        case "3":
            history();
            break;
        case "4":
            disconnected();
            break;
        case "9":
            file_put_contents("usuarios.txt", "");
            system("clear");
            exit;
        default:
            echo "Opção inválida! \n";
    };
}

while (true) {
    if($isLoggedIn) {
        echo "------------------------------- \n";
        echo "1 - Vender \n";
        echo "2 - Novo Usuário \n";
        echo "3 - Verificar Log \n";
        echo "4 - Deslogar \n";
        echo "9 - Sair \n";
        echo "------------------------------- \n";
        $menuOption = readline("Escolha alguma opção do menu: \n");
        menu($menuOption);
        system('clear');
    } else {
        echo "------------------------------- \n";
        echo "1 - Login \n";
        echo "------------------------------- \n";
        $inputLogin = readline("Digite: \n");
        system('clear');
        validationForLoggedOutUser($inputLogin);
    }
};
