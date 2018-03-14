<?php

$arErrors = Array();

if (isset($_POST["secur_chk"])) {
    $arErrors[] = "Проверка от автоматического заполнения не пройдена";
}



if (strlen($_POST["NAME"])==0 || $_POST["NAME"] == "Обязательно"){
    $arErrors[] = "Не заполнено обязательно поле 'Имя'";
}
if (strlen($_POST["PHONE"])==0 || $_POST["PHONE"] == "Обязательно"){
    $arErrors[] = "Не заполнено обязательно поле 'Телефон'";
} else {
    $is_correct_phone = (bool)preg_match('/[0-9\(\)\s\+\-]+/', $_POST["PHONE"]);
    if (!$is_correct_phone) $arErrors[] = "Неправильно заполнено поле 'Телефон'";
}
if (strlen($_POST["AGREE"])==0 || $_POST["AGREE"] == "Обязательно"){
    $arErrors[] = "Необходимо дать согласие на обработку персональных данных";
}
#my_p ($arErrors);
#die();
if (count($arErrors)==0){
    $arFields = Array(
        "NAME" => trim($_POST["NAME"]),
        "PHONE" => $_POST["PHONE"],
    );
    $send = CEvent::Send("NEW_QUICK_ORDER", array("s1"), $arFields,"N","36");
}



