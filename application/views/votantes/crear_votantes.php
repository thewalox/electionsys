	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="<?php echo base_url(); ?>votantes/form_crear/">Votantes</a></li>
						<li class="active">Crear Votantes</li>
					</ol>
				</div>
				
				<div class="container">
					<div id="content2"></div>
					<div class="col-md-4">
						<form name="form">
							<div class="panel panel-primary">
								<div class="panel-heading text-center">Seleccionar Filtros</div>
								<div class="panel-body">
									<div class="row">
										<div class="form-group col-md-12">
											<label for="estado">Eleccion</label>
											<select class="form-control input-sm" id="eleccion" name="eleccion">
												<option value="0">Seleccione Eleccion</option>
												<?php 
													foreach ($elecciones as $ele) {
												?>
												<option value="<?php echo $ele["ideleccion"]; ?>"><?php echo $ele["ideleccion"] . " - " . $ele["desc_eleccion"]; ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="row">
										<div class="form-group col-md-12">
											<label for="estado">Curso</label>
											<select class="form-control input-sm" id="curso" name="curso">
												<option value="0">Seleccione Curso</option>
												<?php 
													foreach ($cursos as $cur) {
												?>
												<option value="<?php echo $cur["idcurso"]; ?>"><?php echo $cur["desc_curso"]; ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="row" align="center">
										<div class="col-md-12">
											<input type="button" name="buscar" id="buscar" value="Buscar" class="btn btn-primary">
										</div>
							  		</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-8">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="form-group">
									<div class="col-md-6">Listado de Estudiantes</div>
									<div class="col-md-6 text-right">
										<a href="#" id="guardar"><img src="<?php echo base_url(); ?>assets/img/guardar.png" height="25px" width="25px" title="Crear Votantes"></a>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div id="content"></div>
							</div>
						</div>
					</div>
				</div>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$(document).on('change','#eleccion',function(){
				$("#content").html("");
			});

			$(document).on('change','#curso',function(){
				$("#content").html("");
			});

			$(document).on('change','#all',function(){
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			});

			$(document).on('click','#guardar',function(){
				var num = 0;
				var votantes = '';
				$('input[name="votantes[]"]:checked').each(
				    function() {
				        num = num + 1;
				        votantes += $(this).val()+',';
				    }
				);

				if(num > 0){
					//document.form.submit();
					var eleccion = $("#eleccion").val();
					var curso = $("#curso").val();

					$.ajax({
				    	type:"POST",
				    	url:"<?php echo base_url('votantes/crear_votantes'); ?>",
				    	data:{
				    		'eleccion'		: 	eleccion,
				    		'curso'			: 	curso,
				    		'votantes'		: 	votantes
				    	},
				    	success:function(data){
				    		console.log(data);
				    		var json = JSON.parse(data);
				    		var html = "";

				    		if (json.mensaje == true) {
								html += "<div class='alert alert-success' role='alert'>Votantes asignados Exitosamente!!!!!</div>";
							}else if(json.mensaje == false){
									html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar asignar estos votantes. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
							}else{
									html += "<div class='alert alert-danger' role='alert'>" + json.mensaje + "</div>";
							}
							
							$("#content2").show("fast");
							$("#content2").html(html);
							$("#content2").fadeOut(5000);
				    	},
				    	error:function(jqXHR, textStatus, errorThrown){
				    		console.log('Error: '+ errorThrown);
				    	}
				    });
				}else{
					alert("Debe seleccionar por lo menos un estudiante para asignarlo a estas elecciones.");
				}
				
			});

			$('#buscar').on('click',function(){

				var eleccion = $("#eleccion").val();
				var curso = $("#curso").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('votantes/get_votantes_eleccion_curso'); ?>",
			    	data:{
			    		'eleccion'		: 	eleccion,
			    		'curso'			: 	curso
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		var html = "";

			    		if (json.error) {
			    			html += "<div class='alert alert-danger' role='alert'>" + json.error + "</div>";
			    		}else{
							html += "<table class='table table-striped table-condensed table-hover'>";
							html += "<thead>";
							html += "<tr>";
							html += "<th>Codigo</th>";
							html += "<th>Nombre Completo</th>";
							html += "<th>Curso</th>";
							html += "<th><input type='checkbox' id='all'></th>";
							html += "</tr>";
							html += "</thead>";
							
								for(datos in json){
									html += "<tr>";
									html +=	"<td>" + json[datos].idestudiante + "</td>";
									html +=	"<td>" + json[datos].nombre_completo + "</td>";
									html +=	"<td>" + json[datos].idcurso + "</td>";
									html +=	"<td><input type='checkbox' name='votantes[]' id='"+ json[datos].idestudiante +"' value='"+ json[datos].idestudiante +"' "; 
									if(json[datos].idvotante != null){  
										html +=	"checked"; 
									} 
									html += "></td>";
									html += "</tr>";
								}
							
							html += "</table>";
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