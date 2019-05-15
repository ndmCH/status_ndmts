<?php 
if(isset($_POST['submit'])){
    $to = "webmaster@ndm-ts.ch"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">   
<title>Report an Incident</title>
<link rel="stylesheet" type="text/css" href="contact.css">
</head>
<body>

<form action="" method="post">
Vorname:    <input type="text" name="first_name"><br>
Nachname:   <input type="text" name="last_name"><br>
Email:      <input type="text" name="email"><br>
Nachricht:<br><textarea rows="5" name="message" cols="30"></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>