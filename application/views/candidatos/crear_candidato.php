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
				
				<?php
					$atributos = array('id' => 'form-candidatos');
					echo form_open_multipart(base_url()."candidatos/crear_candidato", $atributos);
				?>
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
										<div class="form-group col-md-2 ui-widget">
											<label for="codele">Eleccion</label>
											<input type="text" placeholder="Codigo Eleccion" id="codele" name="codele" class="form-control input-sm ui-widget">
										</div>
										<div class="form-group col-md-10">
											<label for="descele">Descripcion Eleccion</label>
											<input type="text" placeholder="Descripcion Eleccion" id="descele" name="descele" class="form-control input-sm" disabled>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-2 ui-widget">
											<label for="codcan">Candidato</label>
											<input type="text" placeholder="Codigo Candidato" id="codcan" name="codcan" class="form-control input-sm">
										</div>
										<div class="form-group col-md-5">
											<label for="nombre">Nombre Completo</label>
											<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" class="form-control input-sm" disabled>
										</div>
										<div class="form-group col-md-2">
											<label for="codcur">Curso</label>
											<input type="text" placeholder="Codigo Curso" id="codcur" name="codcur" class="form-control input-sm" readonly>
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
							                	<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"><i class="glyphicon glyphicon-paperclip"></i> Seleccione Archivo</span><span class="fileinput-exists"><i class="glyphicon glyphicon-repeat"></i> Cambiar</span><input id="file" name="file" type="file" class="file-loading"></span>
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
				<?php
					echo form_close();
				?>
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
      

			$( "#codele" ).autocomplete({
			    source: "<?php echo base_url('elecciones/get_elecciones_criterio'); ?>",
			    select: function( event, ui ) {
				   	//completa_nombre_estudiante(ui.item.label, ui.item.dpto);
				   	$("#descele").val(ui.item.label);
			   	}
			});

			$( "#codcan" ).autocomplete({
			    source: "<?php echo base_url('estudiantes/get_estudiantes_criterio'); ?>",
			    select: function( event, ui ) {
				   	//completa_nombre_estudiante(ui.item.label, ui.item.dpto);
				   	$("#nombre").val(ui.item.label);
				   	$("#codcur").val(ui.item.idcurso);
				   	$("#descur").val(ui.item.descurso);
			   	}
			});

			$( "#codcurul" ).autocomplete({
			    source: "<?php echo base_url('curules/get_curules_criterio'); ?>",
			    select: function( event, ui ) {
				   	//completa_nombre_estudiante(ui.item.label, ui.item.dpto);
				   	$("#descurul").val(ui.item.label);
			   	}
			});


			$('#aceptar').on('click',function(){
				var formData = new FormData(document.getElementById("form-candidatos"));
				var uploadURI = $('#form-candidatos').attr('action');

			    $.ajax({
			    	type:"POST",
			    	url: uploadURI,
			    	dataType: "HTML",
			    	data: formData,
			    	cache: false,
					contentType: false,
					processData: false,
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == true) {
							html += "<div class='alert alert-success' role='alert'>Candidato creado Exitosamente!!!!!</div>";
							$("#codele").val("");
							$("#descele").val("");
							$("#codcan").val("");
							$("#nombre").val("");
							$("#codcur").val("");
							$("#descur").val("");
							$("#codcurul").val("");
							$("#descurul").val("");
							$("#numelec").val("");
							$("#file").replaceWith($("#file").clone());
							document.getElementById("foto").innerHTML = "<img class='img-thumbnail' src='<?php echo base_url(); ?>assets/img/nuevo_usuario.jpg' />";
						}else if(json.mensaje == false){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear este candidato. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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