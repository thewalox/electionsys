	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="<?php echo base_url(); ?>curules/form_buscar/">Curules</a></li>
						<li class="active">Editar Curul</li>
					</ol>
				</div>
				
				<?php
				if (!empty($curul)) {
				?>
				<form name="form">
					<div class="form-group" id="content"></div>

					<div class="panel panel-primary">
						<div class="panel-heading">Nueva Curul</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-2">
									<label for="codigo">Codigo</label>
									<input type="text" placeholder="Codigo Curul" id="codigo" name="codigo" value="<?php echo $curul->idcurul; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-8">
									<label for="descripcion">Descripcion</label>
									<input type="text" placeholder="Descripcion" id="descripcion" name="descripcion" value="<?php echo $curul->desc_curul; ?>" class="form-control input-sm">
								</div>
								<div class="form-group col-md-2">
									<label for="tipo">Tipo</label>
									<select class="form-control input-sm" id="tipo" name="tipo">
										<option value="0">Seleccione Tipo</option>
										<option value="G" <?php if($curul->tipo_curul == 'G'){ ?> selected="selected" <?php } ?>>Global</option>
										<option value="P" <?php if($curul->tipo_curul == 'P'){ ?> selected="selected" <?php } ?>>Privado</option>
									</select>
								</div>
					  		</div>
					  							  		
							<div class="row" align="center">
								<div class="col-md-12">
									<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
									<input type="button" name="cancelar" id="cancelar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'curules/form_buscar'; ?>';">
								</div>
					  		</div>
						</div>
					</div>
				</form>
				<?php
				}else{
				?>	
					<div class='alert alert-danger text-center' role='alert'>No existe curul con este criterio de busqueda.</div>
				<?php
				}
				?>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var codigo = $("#codigo").val();
				var descripcion = $("#descripcion").val();
				var tipo = $("#tipo").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('curules/editar_curul'); ?>",
			    	data:{
			    		'codigo'		: 	codigo,
			    		'descripcion'	: 	descripcion,
			    		'tipo'			: 	tipo
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == true) {
							html += "<div class='alert alert-success' role='alert'>Curul modificada Exitosamente!!!!!</div>";
						}else if(json.mensaje == false){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar modificar esta curul. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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