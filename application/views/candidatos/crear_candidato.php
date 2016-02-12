	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Candidatos</a></li>
						<li class="active">Crear Candidatos</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content"></div>

					<div class="panel panel-primary">
						<div class="panel-heading">Nuevo Candidato</div>
					  	<div class="panel-body">
					  		<div class="row">
								<div class="form-group col-md-3">
									<label for="desceleccion">Foto Candidato</label>
									<output id="foto">
										<img src="<?php echo base_url(); ?>/assets/img/nuevo_usuario.jpg" class="img-thumbnail">
									</output>
								</div>
								<div class="form-group col-md-9">
									<div class="row">
										<div class="form-group col-md-2">
											<label for="codele">Eleccion</label>
											<input type="text" placeholder="Codigo Eleccion" id="codele" name="codele" class="form-control input-sm ui-widget">
										</div>
										<div class="form-group col-md-10">
											<label for="descele">Descripcion Eleccion</label>
											<input type="text" placeholder="Descripcion Eleccion" id="descele" name="descele" class="form-control input-sm" disabled>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-2">
											<label for="codcan">Candidato</label>
											<input type="text" placeholder="Codigo Candidato" id="codcan" name="codcan" class="form-control input-sm">
										</div>
										<div class="form-group col-md-5">
											<label for="nombre">Nombre Completo</label>
											<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" class="form-control input-sm" disabled>
										</div>
										<div class="form-group col-md-2">
											<label for="codcur">Curso</label>
											<input type="text" placeholder="Codigo Curso" id="codcur" name="codcur" class="form-control input-sm" disabled>
										</div>
										<div class="form-group col-md-3">
											<label for="descur">Descripcion Curso</label>
											<input type="text" placeholder="Descripcion Curso" id="descur" name="descur" class="form-control input-sm" disabled>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-2">
											<label for="codcurul">Curul</label>
											<input type="text" placeholder="Codigo Curul" id="codcurul" name="codcurul" class="form-control input-sm">
										</div>
										<div class="form-group col-md-7">
											<label for="descurul">Descripcion Curul</label>
											<input type="text" placeholder="Descripcion Curul" id="descurul" name="descurul" class="form-control input-sm" disabled>
										</div>
										<div class="form-group col-md-3">
											<label for="numelec">Numero Electoral</label>
											<input type="text" placeholder="Numero Electoral" id="numelec" name="numelec" class="form-control input-sm">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-12">
											<label for="foto">Cargar Foto</label>
											<div class="fileinput fileinput-new input-group" data-provides="fileinput">
							                	<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
							                	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"><i class="glyphicon glyphicon-paperclip"></i> Seleccione Archivo</span><span class="fileinput-exists"><i class="glyphicon glyphicon-repeat"></i> Cambiar</span><input id="file" type="file" class="file-loading"></span>
							                	<a href="#" id="upload-btn" class="input-group-addon btn btn-success fileinput-exists" data-loading-text="Importando..." autocomplete="off"><i class="glyphicon glyphicon-open"></i> Importar</a>
						              		</div>
										</div>
									</div>
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


            function cargar_foto(evt) {
                  var files = evt.target.files; // FileList object
             
                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
             
                    var reader = new FileReader();
             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("foto").innerHTML = ['<img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
            }
            
            //se ejecuta cuando selecciono la imagen 
            document.getElementById('file').addEventListener('change', cargar_foto, false);
      

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
			    	url:"<?php echo base_url('Candidatos/crear_estudiante'); ?>",
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
							html += "<div class='alert alert-success' role='alert'>Estudiante creado Exitosamente!!!!!</div>";
							$("#codigo").val("");
							$("#nombre").val("");
							$("#estado").val("0");
							$("#tel").val("");
							$("#idcurso").val("");
							$("#descurso").val("");
							$("#sexo").val("0");
						}else if(json.mensaje == false){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear este estudiante. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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