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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="topnav" id="myTopnav">
        <a href="/index.php" class="text">Home</a>
        <a href="https://attikacloud.ddns.net" class="text">NextCloud</a>
        <a href="./monitor" class="text">Status Login</a>
        <a href="ts3server://81.221.216.103" class="text">Connect to Server</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                   x.className = "topnav";
                }
            } 
        </script>
    </nav>
    <div>        
    <form action="" method="post">
        <label class="text">Vorname:</label><input type="text" name="first_name"><br>
        <label class="text">Nachname:</label><input type="text" name="last_name"><br>
        <label class="text">Email:</label><input type="text" name="email"><br>
        <label class="text">Nachricht:</label>
        <textarea rows="5" name="message" cols="30"></textarea><br>
        <input type="submit" name="submit" value="Report Incident">
    </form>
    </div>