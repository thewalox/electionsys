<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

	<script>
		$(document).ready(function(){

			$('#especies').on('change',function(){
				var filtro = $(this).val();

			    $.ajax({
			    	type:"GET",
			    	url:"<?php echo base_url('home/getData'); ?>",
			    	data:{
			    		'filtro': 	filtro
			    	},
			    	success:function(data){
			    		//console.log(data);
			    		var json = JSON.parse(data);

						var html = "";
						var i = 0;

						html += "<table class='table'>";
						html += "<thead>";
						html += "<tr>";
						html += "<th>#</th>";
						html += "<th>Id</th>";
						html += "<th>Nombre Original</th>";
						html += "<th>Long</th>";
						html += "<th>Lat</th>";
						html += "<th>Municipio</th>";
						html += "<th>Departamento</th>";
						html += "</tr>";
						html += "</thead>";

						for(datos in json){
							i = i + 1;

							html += "<tbody>";
							html += "<tr>";
							html += "<td>"+ i +"</td>";
							html += "<td>"+ json[datos].id +"</td>";
							html += "<td>"+ json[datos].nombre +"</td>";
							html += "<td>"+ json[datos].lon +"</td>";
							html += "<td>"+ json[datos].lat +"</td>";
							html += "<td>"+ json[datos].municipo +"</td>";
							html += "<td>"+ json[datos].departamento +"</td>";
							html += "</tr>";
							html += "</tbody>";
							//console.log(json[datos]);	
							
							//html += "<li class='list-group-item'>"+ json[datos].id +" - "+ json[datos].nombre +"</li>";
							
						}

						html += "</table>";

						$("#content").html(html);
						$("#cantidad").val(i);

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>
</head>
<body>
	<header>
		<div class="container">
			<h1>Informix</h1>		
		</div>
	</header>

	<div class="container">
		<section class="main row">
			<form>
				<aside class="col-md-4">
					<div class="form-group">
						<label for="option">Especies</label>
						<select class="form-control" name="especies" id="especies">
							<option value="0">...</option>
							<?php 
								foreach($especies as $csv){
							?>
                				<option value="<?php echo $csv['especie']; ?>"><?php echo $csv['especie']; ?></option>
            				<?php 
            					}
            				?>
						</select>
					</div>

					<div class="form-group">
						<label for="option">Numero de Registros</label>
						<input type="text" class="form-control" id="cantidad" disabled>
					</div>
				</aside>

				<article class="col-md-8">
					
						<div class="panel panel-primary">
							<div class="panel-heading">Registros de Observación</div>
							<div id="content"></div>
						</div>
					
					
				</article>
			</form>
			
		</section>
	</div>	

	<?php //print_r($especies); ?>
	
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>	
</html>