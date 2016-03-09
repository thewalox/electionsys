	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="<?php echo base_url(); ?>estudiantes/form_buscar/">Estudiantes</a></li>
						<li class="active">Importar Estudiantes en Lote</li>
					</ol>
				</div>
				<?php
					$atributos = array('id' => 'form-upload');
					echo form_open_multipart(base_url()."estudiantes/importar", $atributos);
				?>
				
					<div class="panel panel-primary">
						<div class="panel-heading">Seleccione El archivo</div>
					  		<div class="panel-body">
    							<div class="fileinput fileinput-new input-group" data-provides="fileinput">
					                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
					                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"><i class="glyphicon glyphicon-paperclip"></i> Seleccione Archivo</span><span class="fileinput-exists"><i class="glyphicon glyphicon-repeat"></i> Cambiar</span><input type="file" name="file" id="file"></span>
					                <a href="#" id="upload-btn" class="input-group-addon btn btn-success fileinput-exists" data-loading-text="Importando..." autocomplete="off"><i class="glyphicon glyphicon-open"></i> Importar</a>
				              	</div>
					  		</div>
					</div>
					<div class="progress" style="display:none;">
		              	<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
		                20%
		              	</div>
		            </div>

            		<ul class="list-group"><ul>
					
				<?php
					echo form_close();
				?>
				<div class="form-group" id="content"></div>
			</section>

		</div>
	</section>
	<script>
		$(document).ready(function(){

			var inputFile = $('input#file');
			var uploadURI = $('#form-upload').attr('action');
			var progressBar = $('#progress-bar');

			$('#upload-btn').on('click', function(event) {
				var filesToUpload = inputFile[0].files;
				// make sure there is file(s) to upload
				if (filesToUpload.length > 0) {
					// provide the form data
					// that would be sent to sever through ajax
					var formData = new FormData();

					for (var i = 0; i < filesToUpload.length; i++) {
						var file = filesToUpload[i];
						formData.append("file", file, file.name);				
					}

					var $btn = $(this).button('loading');

					// now upload the file using $.ajax
					$.ajax({
						type: 'POST',
						url: uploadURI,
						data: formData,
						processData: false,
						contentType: false,
						success: function(data) {
							//listFilesOnServer();
							console.log(data);
				    		var json = JSON.parse(data);
				    		//alert(json.mensaje);
							var html = "";
							
							for(datos in json){

								if (json.tipo == 0) {
									html = "<div class='alert alert-danger alert-dismissible text-center' role='alert'>";
		  							html += "<strong>Error al importar este archivo: " + json.errores + "</strong>";
									html += "</div>";	
								}else{
									html = "<div class='alert alert-success alert-dismissible text-center' role='alert'>";
		  							html += "<strong>Archivo importado correctamente</strong>";
		  							html += "<div>Registros Agregados: " + json.add + "</div>";
		  							html += "<div>Registros Actualizados: " + json.edit + "</div>";
									html += "</div>";
								}
							}

							$("#content").html(html);
							$btn.button('reset');
						}
					});
				}
			});

							
		});
	</script>