<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/DotEnv.php';

use DevCoder\DotEnv;
$absolutePathToEnvFile = __DIR__ . '/.env';
(new DotEnv($absolutePathToEnvFile))->load();

session_start();

if (isset($_SESSION['last_submit']) && time() - $_SESSION['last_submit'] < 60) {
  echo "Por favor, aguarde antes de enviar novamente.";
} else {
  // Process the form
  $_SESSION['last_submit'] = time();
}

if( isset($_POST) ){
    $formok = true;

	$field_name = strip_tags($_POST['name']);
	$field_email = strip_tags($_POST["email"]);
	$field_message = strip_tags($_POST["message"]);

	$mail_to = 'info@fabianacorrea.com';
	$subject = 'Quer falar comigo? • Mensagem de '.$field_name;

	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$datetime = date('d/m/Y H:i:s');

	if(empty($field_name)){
		$formok = false;
		?>
		<script language="javascript" type="text/javascript">
			alert('O nome ficou em branco.');
			window.location = 'index.html';
		</script>
	<?php
	}

	if(empty($field_email)){
		$formok = false;
		?>
		<script language="javascript" type="text/javascript">
			alert('O e-mail ficou em branco.');
			window.location = 'index.html';
		</script>
	<?php
	//validate email address is valid 
	}elseif(!filter_var($field_email, FILTER_VALIDATE_EMAIL)){
		$formok = false;
		?>
		<script language="javascript" type="text/javascript">
			alert('O e-mail não é válido.');
			window.location = 'index.html';
		</script>
	<?php
	}

	if(empty($field_message)){
		$formok = false;
		?>
		<script language="javascript" type="text/javascript">
			alert('A mensagem ficou em branco.');
			window.location = 'index.html';
		</script>
	<?php
	}
	//validate message is greater than 20 characters 
	elseif(strlen($field_message) < 20){
		$formok = false;
		?>
		<script language="javascript" type="text/javascript">
			alert('A mensagem precisa ter no mínimo 20 caractéres.');
			window.location = 'index.html';
		</script>
	<?php
	}

	if($formok){
        $mail = new PHPMailer;

        $mail->isSMTP();

        $mail->Host = getenv('SMTP_HOST');  // Specify your SMTP server address
        $mail->Port = getenv('SMTP_PORT');  // Specify your SMTP port (may vary)
        $mail->SMTPAuth = true;           // Enable SMTP authentication
        $mail->Username = getenv('SMTP_USERNAME'); // Your SMTP username
        $mail->Password = getenv('SMTP_PASSWORD'); // Your SMTP password

        $mail->setFrom($field_email, $field_name);

        $mail->addAddress($mail_to);

        $mail->Subject = $subject;

		$body_message = 'De: '.$field_name."\n";
        $body_message .= 'E-mail: '.$field_email."\n";
        $body_message .= 'Mensagem: '.$field_message."\n";
        $body_message .= 'Enviada em: '.$datetime."\n";
        $body_message .= 'A partir do IP: '.$ipaddress;

        $mail->Body = $body_message;

        
        if (!$mail->send()) { ?>
            <script language="javascript" type="text/javascript">
			alert('Mensagem enviada com sucesso.');
			window.location = 'index.html';
		    </script>
            <?php
        } else { ?>
            <script language="javascript" type="text/javascript">
			alert('O envio falhou, por favor escreva diretamente para info@fabianacorrea.com');
			window.location = 'index.html';
		    </script> 
            <?php
        }
        
        
    }
}


?>