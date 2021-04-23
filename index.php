<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

if (isset($_POST["nome"])) {
  $nome = $_POST["nome"];
}

if (isset($_POST["email"])) {
  $email = $_POST["email"];
}

if (isset($_POST["telefone"])) {
  $telefone = $_POST["telefone"];
}

if (isset($_POST["mensagem"])) {
  $mensagem = $_POST["mensagem"];
}

try {
  $mail->isSMTP();
  $mail->Host = $_ENV["HOST"];
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV["EMAIL"];
  $mail->Password = $_ENV["PASSWORD"];
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->setFrom($_ENV["EMAIL"], "Contato");
  $mail->addAddress($email, $nome);

  $mail->isHTML(true);
  $mail->Subject = "Nova mensagem de $email";
  $mail->Body = "$mensagem </br> Telefone: $telefone";

  $mail->send();

  echo "E-mail enviado";
} catch (Exception $e) {
  echo "E-mail não enviado";
}