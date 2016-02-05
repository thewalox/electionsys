	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Estudiantes</a></li>
						<li class="active">Buscar Estudiantes</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'estudiantes/form_buscar'; ?>';">
      						</span>
    					</div>
					</div>
				</div>
				<div class="form-group" id="content">
					<form name="form">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>Nombre Completo</th>
									<th>Curso</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($estudiantes as $est) {
									# code...
							?>
							<tr>
								<td><?php echo $est["idestudiante"]; ?></td>
								<td><?php echo $est["nombre_completo"]; ?></td>
								<td><?php echo $est["idcurso"]; ?></td>
								<td><a href="<?php echo base_url('estudiantes/form_editar/'. $est["idestudiante"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="<?php echo base_url('estudiantes/eliminar_estudiante/'. $est["idestudiante"]); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
							</tr>
							<?php
								}
							?>
						</table>
					</form>
					<div class="row">
						<div class="container">
							<ul class="pagination">
				            <?php
				              /* Se imprimen los números de página */           
				              echo $this->pagination->create_links();
				            ?>
		            		</ul>
						</div>
					</div>		
				</div>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var filtro = $("#filtro").val();
				//alert("ok");
			    $.ajax({
			    	type:"GET",
			    	url:"<?php echo base_url('estudiantes/get_estudiantes_criterio'); ?>",
			    	data:{
			    		'filtro'	: 	filtro
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
			    		var html = "";
						html += "<table class='table table-striped table-condensed table-hover'>";
						html += "<thead>";
						html += "<tr>";
						html += "<th>Codigo</th>";
						html += "<th>Nombre Completo</th>";
						html += "<th>Curso</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].idestudiante + "</td>";
								html +=	"<td>" + json[datos].nombre_completo + "</td>";
								html +=	"<td>" + json[datos].idcurso + "</td>";
								html +=	"<td><a href='<?php echo base_url('estudiantes/form_editar/" + json[datos].idestudiante  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td><a href='<?php echo base_url('estudiantes/eliminar_estudiante/" + json[datos].idestudiante  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
								html += "</tr>";
							}
						
						html += "</table>";
						
						$("#content").html(html);

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>	