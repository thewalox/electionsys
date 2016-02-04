	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Elecciones</a></li>
						<li class="active">Crear Elecciones</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content"></div>

					<div class="panel panel-primary">
						<div class="panel-heading">Nueva Eleccion</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-4">
									<label for="codigo">Codigo</label>
									<input type="text" placeholder="Codigo Eleccion" id="codigo" name="codigo" class="form-control input-sm">
								</div>
					  			<div class="form-group col-md-4">
									<label for="fecini">Fecha Inicial</label>
									<div class='input-group date' id='datetimepicker1'>
						                <input type='text' class="form-control input-sm" name="fecini" id="fecini" />
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
								<div class="form-group col-md-4">
									<label for="fecfin">Fecha Final</label>
									<div class='input-group date' id='datetimepicker2'>
						                <input type='text' class="form-control input-sm" name="fecfin" id="fecfin" />
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
					  		</div>
					  		<div class="row">
					  			<div class="form-group col-md-12">
									<label for="descripcion">Descripcion</label>
									<input type="text" placeholder="Descripcion" id="descripcion" name="descripcion" class="form-control input-sm">
								</div>
					  		</div>
							<div class="row" align="center">
								<div class="col-md-12">
									<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
								</div>
					  		</div>
						</div>
					</div>
				</form>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var codigo = $("#codigo").val();
				var fecini = $("#fecini").val();
				var fecfin = $("#fecfin").val();
				var descripcion = $("#descripcion").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('elecciones/crear_eleccion'); ?>",
			    	data:{
			    		'codigo'		: 	codigo,
			    		'fecini'		: 	fecini,
			    		'fecfin'		: 	fecfin,
			    		'descripcion'	: 	descripcion
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == true) {
							html += "<div class='alert alert-success' role='alert'>Eleccion creada Exitosamente!!!!!</div>";
							$("#codigo").val("");
							$("#fecini").val("");
							$("#fecfin").val("");
							$("#descripcion").val("");
						}else if(json.mensaje == false){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear esta eleccion. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
						}else{
								html += "<div class='alert alert-danger' role='alert'>" + json.mensaje + "</div>";
						}
						

						$("#content").html(html);

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>