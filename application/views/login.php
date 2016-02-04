<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/md5.js"></script>
</head>
<body>
	<div class = "container">
	<div class="wrapper">
		<form action="" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Acceso al Sistema</h3>
			  <hr class="colorgraph"><br>
			  
			<div class="input-group" id="user">
            	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="usuario" id="usuario" value="" placeholder="Usuario" autofocus="">                                        
            </div>
			<div class="input-group" id="pass">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" name="clave" id="clave" placeholder="Contraseña">
            </div>  		  
			<div id="content"></div>
			<button class="btn btn-lg btn-primary btn-block" id="login" value="Login" type="button">Login</button>  			
		</form>
					
	</div>
</div>
<script>
		$(document).ready(function(){
			
			$('#login').on('click',function(){
				var user = $("#usuario").val();
				var pass = $("#clave").val();
				var html = "";
				var encrypt = "";

				if (user == 0){
					$( "div[id='user']" ).addClass( "form-group has-error" );
					$('#usuario').focus();
		            return false;
		    	}else{
		    		$( "div[id='user']" ).removeClass( "has-error" );
		    	}

		    	if (pass == 0){
					$( "div[id='pass']" ).addClass( "form-group has-error" );
					$('#clave').focus();
		            return false;
		    	}else{
		    		$( "div[id='pass']" ).removeClass( "has-error" );
		    	}

		    	encrypt = calcMD5(pass);
				
				$.post("<?php echo site_url('login/validar_usuario'); ?>", 
					{usuario: user, clave: encrypt}, function(result){
						if (result == "ok") {
							window.location = "<?php echo site_url('home'); ?>";
						}else{
							html = "<p class='text-danger text-center'>Usuario o Contraseña incorrecta.</p>";
							$("#content").html(html);
						};
				});

			});

		});
</script>
</body>
</html>

