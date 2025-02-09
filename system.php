<?php

$currentUser;

$isLoggedIn = (bool) false;

$dataBase = [];
$dataBase["admin"] = '12345';

function login() {
    $user = readline("User: \n");
    $password = readline("Senha: \n");
    userValidation($user, $password);
}

function productSales () {
    global $currentUser;
    
    system("clear");

    $productName = readline("Nome do Produto: \n");
    $price = readline("Preço: \n");

    $message = $currentUser . "      Venda (Produto): " . $productName . "    Preço: R$:" . $price . "    ". date('d/m/Y H:i:s') . " \n";
    file_put_contents('usuarios.txt', $message, FILE_APPEND);

    system("clear");
};

function disconnected () {
    global $isLoggedIn;
    global $currentUser;

    $message = "Usuário $currentUser deslogado em:  " . date('d/m/Y H:i:s') . " \n";
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

            $message = "Usuário $currentUser logado " . date('d/m/Y H:i:s') . " \n";
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
            break;
        case "3":
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
