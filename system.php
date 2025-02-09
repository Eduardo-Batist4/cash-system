<?php


function validationForLoggedOutUser ($num) {
    if ($num == 1) {
        system('clear');
    } else {
        system('clear');
        echo "------------------------------- \n";
        echo "Opção inválida! \n";
    };
};

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
