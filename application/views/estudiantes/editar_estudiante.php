	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="<?php echo base_url(); ?>estudiantes/form_buscar/">Estudiantes</a></li>
						<li class="active">Editar Estudiante</li>
					</ol>
				</div>
				
				<?php
				if (!empty($estudiante)) {
				?>
				<form name="form">
					<div class="form-group" id="content"></div>

					<div class="panel panel-primary">
						<div class="panel-heading">Editar Estudiante</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-3">
									<label for="codigo">Codigo</label>
									<input type="text" placeholder="Codigo Estudiante" id="codigo" name="codigo" value="<?php echo $estudiante->idestudiante; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-6">
									<label for="nombre">Nombre Completo</label>
									<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" value="<?php echo $estudiante->nombre_completo; ?>" class="form-control input-sm">
								</div>
								<div class="form-group col-md-3">
									<label for="estado">Estado</label>
									<select class="form-control input-sm" id="estado" name="estado">
										<option value="0">Seleccione Estado</option>
										<option value="A" <?php if($estudiante->estado == 'A'){ ?> selected="selected" <?php } ?>>Activo</option>
										<option value="I" <?php if($estudiante->estado == 'I'){ ?> selected="selected" <?php } ?>>Inactivo</option>
									</select>
								</div>
					  		</div>
					  		<div class="row">
					  			<div class="form-group col-md-3">
									<label for="telefono">Telefono</label>
									<input type="text" placeholder="Telefono" id="tel" name="tel" value="<?php echo $estudiante->telefono; ?>" class="form-control input-sm">
								</div>
								<div class="form-group col-md-2 ui-widget">
									<label for="curso">Curso</label>
									<input type="text" placeholder="Codigo Curso" id="idcurso" name="idcurso" value="<?php echo $estudiante->idcurso; ?>" class="form-control input-sm">
								</div>
								<div class="form-group col-md-4">
									<label for="desc">Descripcion Curso</label>
									<input type="text" placeholder="Descripcion Curso" id="descurso" name="descurso" value="<?php echo $estudiante->desc_curso; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-3">
									<label for="sexo">Sexo</label>
									<select class="form-control input-sm" id="sexo" name="sexo">
										<option value="0">Seleccione Sexo</option>
										<option value="M" <?php if($estudiante->sexo == 'M'){ ?> selected="selected" <?php } ?>>Masculino</option>
										<option value="F" <?php if($estudiante->sexo == 'F'){ ?> selected="selected" <?php } ?>>Femenino</option>
									</select>
								</div>
					  		</div>
					  							  		
							<div class="row" align="center">
								<div class="col-md-12">
									<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
									<input type="button" name="cancelar" id="cancelar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'estudiantes/form_buscar'; ?>';">
								</div>
					  		</div>
						</div>
					</div>
				</form>
				<?php
				}else{
				?>	
					<div class='alert alert-danger text-center' role='alert'>No existe estudiante con este criterio de busqueda.</div>
				<?php
				}
				?>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$( "#idcurso" ).autocomplete({
			    source: "<?php echo base_url('cursos/get_cursos_criterio'); ?>",
			    select: function( event, ui ) {
				   	//completa_nombre_estudiante(ui.item.label, ui.item.dpto);
				   	$("#descurso").val(ui.item.label);
			   	}
			});

			$('#aceptar').on('click',function(){
				var codigo = $("#codigo").val();
				var nombre = $("#nombre").val();
				var estado = $("#estado").val();
				var tel = $("#tel").val();
				var curso = $("#idcurso").val();
				var sexo = $("#sexo").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('estudiantes/editar_estudiante'); ?>",
			    	data:{
			    		'codigo'	: 	codigo,
			    		'nombre'	: 	nombre,
			    		'estado'	: 	estado,
			    		'tel'		: 	tel,
			    		'curso'		: 	curso,
			    		'sexo'		: 	sexo
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == true) {
							html += "<div class='alert alert-success' role='alert'>Estudiante modificado Exitosamente!!!!!</div>";
						}else if(json.mensaje == false){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar modificar este estudiante. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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