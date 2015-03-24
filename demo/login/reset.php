<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

if (!empty($_GET['reset'])) {
    $emailsha = $_GET['reset'];
    
    $query = $con->prepare("SELECT * FROM users WHERE `users_reset` = '$emailsha'");
    $query -> execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    if (!empty($user)) { ?>
        <form method="post" action="/login/reset.php">
            <label>Password:</label>
            <input type="password" name="password">
            <label>Password confirm:</label>
            <input type="password" name="password2">
            <input type="hidden" name="reset" value="<?php echo $_GET['reset']; ?>">
            <input type="submit" value="Change Password">
        </form>
<?php
    } else {
        header('Location: /login/');
    }
} else if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $emailsha = $_POST['reset'];
    
    $query = $con->prepare("SELECT `users_id`, `users_salt` FROM users WHERE `users_reset` = '$emailsha'");
    $query -> execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    $passwordsha = sha1($password . $user['users_salt']);
    
    $query = $con->prepare("UPDATE users SET `users_password` = '$passwordsha', `users_reset` = NULL WHERE `users_reset` = '$emailsha'");
    
    try {	
		$query->execute();
	} catch (PDOException $e) {
		echo "Server error: something has gone wrong, please try again";
	}
    
    header('Location: /login/?reset=success');
    
} else if (!empty($_GET['email'])) {
    $email = $_GET['email'];
    $emailsha = sha1($email);
    $query = $con->prepare("UPDATE users SET `users_reset` = '$emailsha' WHERE `users_email` = '$email'");
    $message = "You can been sent a password reset email.";
    
    try {	
		$query->execute();
	} catch (PDOException $e) {
        $message = "That email is not registered in our database.";
	}
    require($_SERVER['DOCUMENT_ROOT'] . "/includes/phpmailer/class.phpmailer.php");
    $emailMessage = "Hi,

You have requested a password reset email.
Please click the link below to change your password:

http://" . $_SERVER['HTTP_HOST'] . "/login/reset.php?reset=" . $emailsha . "

Task Managr";
    
    $mail = new PHPMailer();
    $mail->IsSMTP();  // telling the class to use SMTP
    $mail->Host     = "10.168.1.70"; // SMTP server
    $mail->SetFrom("no-reply@taskmanagr.co.uk", 'Task Managr Notification');
    $mail->AddAddress($email);
    $mail->Subject  = 'Task Managr Password reset';
    $mail->Body     = $emailMessage;
    $mail->WordWrap = 78;
    
    if(!$mail->Send()) { 
        $message = "Email failed to send, please try again.";
    }
    
    echo $message;
    
} else { ?>
    <p>Please type in your email address to request a password reset email</p>
    <form action="/login/reset.php" method="GET">
        <input type="email" name="email">
        <input type="submit" value="Submit">
    </form>
<?php } ?>