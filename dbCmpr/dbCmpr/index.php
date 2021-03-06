<?php
	@session_start();
	
	use Compare\Db\App;
	
	require( 'source/config.php' );
	require( 'public/interface/public_interface.php' );
	require( 'source/functions.php' );
	
	//check login post
	if( isset( $_POST['submit'] ) )
	{
		$loginResult = checkIfPost();
		$loginResult = json_decode($loginResult);		
		unset( $_POST );	
	}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
  <!--<h1>Material Login Form</h1>-->
</div>

<div class="rerun">
<?php	
	if( ( isset( $loginResult->data->message ) && $loginResult->data->message == 'error' ) ) :
?>	
	<a href="#"><?php print $loginResult->data->type; ?></a></div>
<?php	
	endif;
?>	

<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
	<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
    <form type="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
      <div class="input-container">
        <input type="text" name="user_name" required="required"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" name="user_pass" required="required"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <!--<button><span>Go</span></button>-->
		<input type="submit" name="submit" value="GO">		
      </div>
      <!--<div class="footer"><a href="#">Forgot your password?</a></div>-->
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
