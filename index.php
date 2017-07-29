<?php
  //Message vars
  $msg = '';
  $msgClass = '';

  //Check for submit
  if(filter_has_var(INPUT_POST, 'submit')){
    //Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    //Check required fields
    if(!empty($email) && !empty($name) && !empty($message)){
      //Check email
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $msg = 'Please submit valid email address';
        $msgClass = 'alert-danger';
      } else {
        //Recipient email
        $toEmail = 'glenadobbs@gmail.com';
        $subject = 'Contact request from ' . $name;
        $body = '<h2>Contact request</h2>
                 <h4>Name</h4><p>'.$name.'</p>
                 <h4>Email</h4><p>'.$email.'</p>
                 <h4>Message</h4><p>'.$message.'</p>
        ';
        //Email headers
        $headers = "MIME-Version: 1.0" ."\r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " .$name. "<".$email.">". "\r\n";

        if(mail($toEmail, $subject, $body, $headers)){
          $msg = 'Your message has been sent';
          $msgClass = 'alert-success';
        } else {
          $msg = 'Unable to send message';
          $msgClass = 'alert-danger';
        }
      }
    } else {
      $msg = 'Please fill in all fields';
      $msgClass = 'alert-danger';
    }
  }

 ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css">
    <title>Contact Us</title>
  </head>
  <body>
    <nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">My Website</a>
          </div>
        </div>
      </nav>
      <div class="container">
        <?php if($msg != ''): ?>
          <div class="alert <?php echo $msgClass; ?>">
            <?php echo $msg ?>
          </div>
        <?php endif; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo isset($_POST['name'])? $name : ''; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo isset($_POST['email'])? $email : ''; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea type="text" name="message" class="form-control"><?php echo isset($_POST['message'])? $message : ''; ?></textarea>
          </div>
          <br />
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

  </body>
</html>
