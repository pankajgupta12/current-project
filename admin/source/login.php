<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><? echo Site_name?></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>
<style type="text/css">
	.container { position:relative;}
	.login_main { margin: 0;
	width:100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, 50%);}

.right-panel-tittle {
    font-size: 20px;
    padding: 10px 0px;
}
.logo {
    padding-top: 30px;
}
.m-login__form-action button {
    background-color: #0093dd;
    color: #fff;
    width: 100%;
    padding: 10px 0px;
    font-size: 20px;
    font-weight: 600;
}
.m-login__form-action button:hover { background-color:#333;}


@media screen and (max-width:1024px){
    
     .left-img img {  width: 100%;}
    
}

@media screen and (max-width:767px){
    .login_main {  margin: 0; width: 100%; position: relative; top: inherit; left: inherit; transform: translate(0%, 0%);}
    .left-img img {  width: 100%;}
}


</style>

<body>

<div class="container">
	<div class="login_main">
	<div class="row">
    
    	<div class="col-md-7">
        	<div class="left-img"><img src="../img/left-img.jpg" alt="img"/></div>
        </div>
        
        
        <div class="col-md-5">
        	<div class="logo"> <img src="../img/Logo-1.png" alt="logo"/></div>
        	<h2 class="right-panel-tittle">Please enter your username and password below to log in to the <? echo  Site_name;?> Administration Zone.</h2>
			
			<?php if(isset($_GET['action']) && $_GET['action'] == 'error') { ?>
			   <p style="font-size: 13px; margin: 3px; color: red; font-weight: 600; padding-top: -4px;">Login failed: Username / password mismatch</p>
			<?php  } else if(isset($_GET['action']) && $_GET['action'] == 'serror') { ?>
			   <p style="font-size: 13px; margin: 3px; color: red; font-weight: 600; padding-top: -4px;">Something went wrong into your access.</p>
			<?php  } ?>
			
            <form class="m-login__form m-form" method="post" action="<? echo  $_SERVER['SCRIPT_NAME'];?>">
              <div class="form-group m-form__group">
                <input class="form-control m-input" type="text" placeholder="Email" name="username"  >
              </div>
              <div class="form-group m-form__group">
                <input class="form-control m-input m-login__form-input--last" type="password"  autocomplete="off" placeholder="Password"  name="pass">
              </div>
              
              <div class="row m-login__form-sub">
                <div class="col m--align-left">
                  <label class="m-checkbox m-checkbox--focus">
                    <input name="rem" type="checkbox" id="rem" value="checkbox" <? if($_COOKIE['bcic']!=""){ echo "selected"; }?>>
                    Remember me <span></span> </label>
                </div>
              </div>
                <div class="m-login__form-action">
			        <input type="hidden" name="login" value="1"> 
                    <input type="hidden" name="task" value="<? echo rw("task"); ?>"> 
                    <input type="hidden" name="action" value="<? echo rw("action"); ?>"> 
					
						<?php  if($_GET['__SK__'] != '') { ?>
						<input type="hidden" name="scname" value="<?php echo $_GET['__SK__']; ?>"> 
						<?php  } ?>
						
                    <button id="m_login_signin_submit" name="Submit"  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Log In</button>
					
					<!--<input  id="m_login_signin_submit" name="Submit" type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" value="Log In">-->
               </div>
            </form>
        </div>
     </div>   
	</div>
</div>

</body>
</html>
