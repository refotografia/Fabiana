<?php
if( isset($_POST) ){
    $formok = true;

	$field_name = $_POST["name"];
	$field_email = $_POST["email"];
	$field_message = $_POST["message"];

	$mail_to = 'fabi@fabianacorrea.com';
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
		$body_message = 'De: '.$field_name."\n";
	$body_message .= 'E-mail: '.$field_email."\n";
	$body_message .= 'Mensagem: '.$field_message."\n";
	$body_message .= 'Enviada em: '.$datetime."\n";
	$body_message .= 'A partir do IP: '.$ipaddress;

	$headers = 'From: '.$field_email."\r\n";
	$headers .= 'Reply-To: '.$field_email."\r\n";

	$mail_status = mail($mail_to, $subject, $body_message, $headers);
	}
}

	if ($mail_status) { ?>
		<script language="javascript" type="text/javascript">
			alert('Mensagem enviada com sucesso.');
			window.location = 'index.html';
		</script>
	<?php
	} 	else { ?>
		<script language="javascript" type="text/javascript">
			alert('O envio falhou, por favor escreva diretamente para fabi@fabianacorrea.com');
			window.location = 'index.html';
		</script> 
	<?php
	}

?>