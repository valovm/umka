<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function



require_once 'phpMailer/PHPMailer.php';
require_once 'phpMailer/SMTP.php';
require_once 'phpMailer/Exception.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;











$result = array(
    'errors' => array(),
    'send' => false,
);
$body = ''; $alt_body = '';

if(!isset($_POST["agree"])) {
    $result['errors'][] = "Необходимо дать согласие на обработку персональных данных";
}

    foreach ($_POST['fields'] as $name_field => $field){
        switch ($name_field){

            case 'name':
                if(strlen($field) == 0) $result['errors'][] = "Не заполнено обязательно поле 'Имя'";
                break;
            case 'phone':
                if(strlen($field) == 0) $result['errors'][] = "Не заполнено обязательно поле 'Телефон'";
                $is_correct_phone = (bool)preg_match('/[0-9\(\)\s\+\-]+/', $field);
                if (!$is_correct_phone) $result['errors'][] = "Неправильно заполнено поле 'Телефон'";
                break;
            case 'email':
                if(strlen($field) == 0) $result['errors'][] = "Не заполнено обязательно поле 'Email'";
                break;



        }
        $body .= $field . '<br>';
        $alt_body .= $field ."\n";
    }




if(count($result['errors']) == 0){
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'valovneprokin@gmail.com';                 // SMTP username
        $mail->Password = '5Pz-2KJ-6oh-Tos';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;


        //Recipients
        $mail->setFrom('valovneprokin@gmail.com', 'Mailer');
        $mail->addAddress('valov@v-n.io', 'Joe User');     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Umka: Заявка на подключение';
        $mail->Body    = $body;
        $mail->AltBody = $alt_body;

       // $mail->send();
        $result['send'] = true;
    } catch (Exception $e) {
        $result['errors'][] = $mail->ErrorInfo;
    }
}

print  json_encode($result, JSON_PRETTY_PRINT);


