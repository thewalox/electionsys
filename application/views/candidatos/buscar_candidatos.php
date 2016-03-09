	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="<?php echo base_url(); ?>candidatos/form_buscar/">Candidatos</a></li>
						<li class="active">Buscar Candidatos</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'Candidatos/form_buscar'; ?>';">
      						</span>
    					</div>
					</div>
				</div>
				<div class="form-group" id="content">
					<form name="form">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">Eleccion</th>
									<th class="text-center">Documento</th>
									<th>Nombre Completo</th>
									<th class="text-center">Curso</th>
									<th>Curul</th>
									<th class="text-center">Foto</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($candidatos as $cand) {
									# code...
							?>
							<tr>
								<td class="text-center" style="vertical-align: middle;"><?php echo $cand["ideleccion"]; ?></td>
								<td class="text-center" style="vertical-align: middle;"><?php echo $cand["idcandidato"]; ?></td>
								<td style="vertical-align: middle;"><?php echo $cand["nombre_completo"]; ?></td>
								<td class="text-center" style="vertical-align: middle;"><?php echo $cand["idcurso"]; ?></td>
								<td style="vertical-align: middle;"><?php echo $cand["desc_curul"]; ?></td>
								<td class="text-center" style="vertical-align: middle;"><img class="img-thumbnail" src="data:image/jpeg;base64,<?php echo base64_encode($cand['foto']); ?>" width="50px" height="50px"></td>
								<td style="vertical-align: middle;"><a href="<?php echo base_url('candidatos/form_editar/'. $cand["ideleccion"] .'/'. $cand["idcandidato"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td style="vertical-align: middle;"><a href="<?php echo base_url('candidatos/eliminar_candidato/'. $cand["ideleccion"] .'/'. $cand["idcandidato"]); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
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
			    	url:"<?php echo base_url('candidatos/get_candidatos_criterio'); ?>",
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
						html += "<th class='text-center'>Eleccion</th>";
						html += "<th class='text-center'>Documento</th>";
						html += "<th>Nombre Completo</th>";
						html += "<th class='text-center'>Curso</th>";
						html += "<th>Curul</th>";
						html += "<th class='text-center'>Foto</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td class='text-center' style='vertical-align: middle;'>" + json[datos].ideleccion + "</td>";
								html +=	"<td class='text-center' style='vertical-align: middle;'>" + json[datos].idcandidato + "</td>";
								html +=	"<td style='vertical-align: middle;'>" + json[datos].nombre_completo + "</td>";
								html +=	"<td class='text-center' style='vertical-align: middle;'>" + json[datos].idcurso + "</td>";
								html +=	"<td style='vertical-align: middle;'>" + json[datos].desc_curul + "</td>";
								html += "<td class='text-center' style='vertical-align: middle;'><img id='foto' class='img-thumbnail' src='data:image/jpeg;base64," + json[datos].foto + "' width='50px' height='50px'></td>";
								html +=	"<td style='vertical-align: middle;'><a href='<?php echo base_url('candidatos/form_editar/" + json[datos].ideleccion  + "/" + json[datos].idcandidato + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td style='vertical-align: middle;'><a href='<?php echo base_url('candidatos/eliminar_candidato/" + json[datos].ideleccion  + "/" + json[datos].idcandidato + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
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