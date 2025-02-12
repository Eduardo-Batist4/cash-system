<?php

$currentUser; // Salvar nome do usuario logado

$totalSales = 0;

$isLoggedIn = (bool) false; 

$dataBase = []; // Armazenamento Usuarios
$dataBase["admin"] = '12345'; // Usuário teste;

$dataBaseProduct = []; // Armazenamento Produtos

// ----------- Menu Functions --------- //

function login() {
    $user = readline("User: \n");
    $password = readline("Senha: \n");
    userValidation($user, $password);
}

function productSales () {
    system("clear");

    $idProduct = readline("ID do produto: ");

    checkStock($idProduct);
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

function registerProduct () {
    global $currentUser;
    global $dataBaseProduct;

    $productID = readline("ID: \n");
    $productName = readline("Nome do Produto: \n");
    $price = readline("Preço: \n");
    $stock = readline("Estoque: \n");

    $dataBaseProduct[] = ["id" => $productID, "name" => $productName, "price" => $price, "stock" => $stock];

    $message = "($currentUser)  CADASTRO DE PRODUTO      ID: $productID      Name: $productName      Preço: $price      Estoque: $stock      " . date('d/m/Y H:i:s') . " \n";
    file_put_contents('usuarios.txt', $message, FILE_APPEND);

    system("clear");
    echo "------------------------------- \n";
    echo "Produto cadastrado com sucesso! \n";
    echo "------------------------------- \n";
    readline("Aperte Enter para voltar ao menu! \n");
    system("clear");
}

function productsAvailable () {
    global $dataBaseProduct;

    system("clear");
    echo "------------------------------- \n";
    echo "Produto Disponíveis! \n";
    echo "------------------------------- \n";
    foreach ($dataBaseProduct as &$item) {
        echo "ID: " . $item["id"] . "   Name: " . $item["name"] . "   Preço: " . $item["price"] . "   Estoque: " . $item["stock"] . " \n";
    };
    echo "------------------------------- \n";

    readline("Aperte Enter para voltar ao menu! \n");
    system("clear");
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
    echo "Total de vendas: R$:" . number_format($totalSales, 2) . "\n";
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

// ------------------------------------ //

// ------------ Validation ------------ //

function checkStock ($id) {
    global $dataBaseProduct;
    global $currentUser;
    global $totalSales;

    foreach ($dataBaseProduct as &$item) {
        if ($item["id"] ==  $id) {
            if ($item["stock"] >= 1) {
                $item["stock"] = $item["stock"] - 1;

                $totalSales += $item["price"];

                $message = "($currentUser)  VENDA      " . "ID: " . $item["id"] . "   Nome: " . $item["name"] . "   Preço: " . $item["price"] . "   Estoque: " . $item["stock"] . "      " . date('d/m/Y H:i:s') . " \n";
                file_put_contents('usuarios.txt', $message, FILE_APPEND);
                return;
            };
        };
    };
    system("clear");
    echo "------------------------------- \n";
    echo "Produto em falta no estoque! \n";
    echo "------------------------------- \n";        
    readline("Aperte Enter para voltar ao menu! \n");   
    system("clear");
};

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

// ----------------------------------- //

// -------------- Menu --------------- //

function menu ($num) {
    switch ($num) {
        case "1":
            productSales();
            break;
        case "2":
            newUser();
            break;
        case "3":
            registerProduct();
            break;
        case "4":
            productsAvailable();
            break;
        case "5":
            history();
            break;
        case "6":
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
        echo "3 - Cadastrar Produto \n";
        echo "4 - Produtos Disponíveis \n";
        echo "5 - Verificar Log \n";
        echo "6 - Deslogar \n";
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
