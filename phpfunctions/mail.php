<?php 
	function send_mail($to,$subject,$htmlmsg,$alt,$account_id,$attach="",$fromemail="chiangochen@gmail.com",$fromname="Victor Chen",$replyemail="chiangochen@gmail.com",$replyname="Victor Chen"){
		require 'C:\WebHost\PHPMailer-master\PHPMailerAutoload.php';
		
		$mail = new PHPMailer;
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//2;
		$mail->Debugoutput = 'html';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;//465
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "chiangochen@gmail.com";
		$mail->Password = "1357980vic";
		
		$pos = strpos($htmlmsg,"http://chiango.no-ip.org/account_activation.php?");
		$first_part = substr($htmlmsg,0,$pos);
		$second_part = substr( $htmlmsg , $pos+strlen("http://chiango.no-ip.org/account_activation.php?") );
		$htmlmsg = $first_part . "http://chiango.no-ip.org/account_activation.php?account_id=" . $account_id . $second_part;
		
		$mail->setFrom($fromemail, $fromname);
		$mail->addReplyTo($replyemail, $replyname);
		$mail->addAddress($to);
		$mail->Subject = $subject;
		//$mail->msgHTML(file_get_contents('C:\Webhost\htdocs\other\basic.html'), dirname(__FILE__));
		$mail->msgHTML($htmlmsg);
		//Replace the plain text body with one created manually
		$mail->AltBody = $alt;
		$mail->addAttachment($attach);
		if (!$mail->send()) {return $mail->ErrorInfo;} 
		else {return true;}
	}
?>