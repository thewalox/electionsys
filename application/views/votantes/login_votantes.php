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
		    <h3 class="form-signin-heading">Digite su documento de identidad</h3>
			  <hr class="colorgraph"><br>
			  
			<div class="input-group" id="user">
            	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="documento" id="documento" value="" placeholder="Documento de Identidad" autofocus="">                                        
            </div>
			<div id="content"></div>
			<button class="btn btn-lg btn-primary btn-block" id="login" value="Login" type="button">Entrar</button>  			
		</form>
					
	</div>
</div>
<script>
		$(document).ready(function(){
			
			$('#login').on('click',function(){
				var documento = $("#documento").val();
				var html = "";

				if (documento == 0){
					$( "div[id='user']" ).addClass( "form-group has-error" );
					$('#documento').focus();
		            return false;
		    	}else{
		    		$( "div[id='user']" ).removeClass( "has-error" );
		    	}
				
				$.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('votantes/validar_votante'); ?>",
			    	data:{
			    		'documento'		: 	documento
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";

						if (json.mensaje == "ok") {
							window.location = "<?php echo site_url('votantes/tarjeton'); ?>";
						}else{
							html += "<div class='alert alert-danger' role='alert'>" + json.mensaje + "</div>";
							$("#content").html(html);
						};
						
						

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});

		});
</script>
</body>
</html>

