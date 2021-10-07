<?php

$errors = [];
$errorMessage = '';
//if we use Json.stringify in the Ajax we use the code down below
/*
$dataJsonString = key($_POST); // data is a string form ->  {"name":"name","subject":"subject","message":"message","email":"mail@mail_com"}
$dataArray = json_decode($dataJsonString, true); // convert data to an array
*/

//if have a normal code from Ajax so we use the code down below

if (!empty($_POST)) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $email = $_POST['email'];

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($subject)) {
        $errors[] = 'Subject is empty';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }  


    if (empty($errors)) {

    // if we using SENDMAIL (simple mail sender) we use code below :
        /*
        $toEmail = 'zakibouf23@gmail.com';  // email of the receiver 
        $emailSubject = 'New email from your contant form';  // email subject
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Message:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

         if (mail($toEmail, $emailSubject, $body, $headers)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
        */

    // if we use PHPMAILER API we use code below :

        require '../assets/vendor/PHPMailer/v5.2/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail -> Host = 'smtp.gmail.com';
        $mail -> Port = 587;
        $mail -> SMTPAuth = true;
        $mail -> SMTPSecure = 'tls';
        $mail -> Username = 'elzakidev@gmail.com';  // an existant google account
        $mail -> Password = 'Dev_93_elZaki';  // password of the existant google account
        $mail -> setFrom($email,$name);
        $mail -> addAddress('zakibouf23@gmail.com');
        $mail -> IsSMTP(true);
        $mail ->SMTPDebug = 3;
        $mail -> Subject = $subject;
        $mail -> Body = $message;

        if(!$mail -> send()){
            echo json_encode(array('success' => false));
        } else {
            echo json_encode(array('success' => true));
        }

    } else {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
        echo json_encode(array('success' => false));
    }
}

?>