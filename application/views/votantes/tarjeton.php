<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/formToWizard.js"></script>
	
</head>
<body>

	<div class = "container">
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
			<div class="navbar-header">
				<a href="<?php echo base_url(); ?>votantes" class="navbar-brand">ElectionSys - Tarjeton Electoral Virtual</a>
			</div>
		</nav>

        <form id="tarjeton">
        <?php
        	foreach ($curules as $curul) {
        ?>
	        <fieldset>
	            <legend><div class="alert alert-info" role="alert"><?php echo $curul["desc_curul"]; ?></div></legend>
	            
	            <div class="row">
	            	<?php
	            	foreach ($candidatos as $cand) {
	            		if($curul["idcurul"] == $cand["idcurul"]){
	            	?>
					<div class="col-sm-4 col-md-3">
				    	<div class="thumbnail">
				      		<img class="img-circle" src="data:image/jpeg;base64,<?php echo base64_encode($cand['foto']); ?>" width="120px" alt="...">
				      		<div class="caption">
				        		<h4><div class="text-center"><?php echo $cand["nombre_completo"]; ?></div></h4>
				        		<ul class="list-group">
								 	<li class="list-group-item active">Numero Electoral: <span class="badge"><?php echo $cand["numero_electoral"]; ?></span></li>
								</ul>
								<ul class="list-group">
								 	<li class="list-group-item active">Curso: <span class="badge"><?php echo $cand["desc_curso"]; ?></span></li>
								</ul>
				      		</div>
				    	</div>
				  	</div>
					<?php
						}
					}
					?>
					<div class="col-sm-4 col-md-3">
				    	<div class="thumbnail">
				      		<img class="img-rounded" src="<?php echo base_url(); ?>/assets/img/voto_blanco.jpg" width="180px" alt="...">
				      		<div class="caption">
				        		<h4><div class="text-center">VOTO EN BLANCO</div></h4>
				      		</div>
				    	</div>
				  	</div>
				</div>
				
	        </fieldset>
        <?php
        	}
        ?>
	        <div class="row">
	        	<div class="col-md-12">
	        		<button type="button" id="SaveAccount" class="btn btn-primary btn-lg btn-block">Guardar Votacion</button>
	        	</div>
		       	
		    </div>   
        </form>
        
    </div>
</body>

	<script type="text/javascript">
        $(document).ready(function(){
            $("#tarjeton").formToWizard({ submitButton: 'SaveAccount' })
        });
    </script>