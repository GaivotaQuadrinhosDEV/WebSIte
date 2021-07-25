<?php

function sendEmail($destinatario,$email,$nome,$status,$mensagem,$assunto) : void{

 // monta o e-mail na variavel $body

$body = "===================================" . "\n";
$body = $body . $assunto . "\n";
$body = $body . "===================================" . "\n\n";
$body = $body . $mensagem . "\n\n";
$body = $body . "===================================" . "\n";

// envia o email

if (mail($destinatario, $assunto , $body, "From: $email\r\n")) {
    echo "Email successfully sent to $destinatario...";
} else {
    echo "Email sending failed...";
}
}

?>

 