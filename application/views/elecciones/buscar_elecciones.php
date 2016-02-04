	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Elecciones</a></li>
						<li class="active">Buscar Elecciones</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'elecciones/form_buscar'; ?>';">
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
									<th>Descripcion</th>
									<th>Estado</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($elecciones as $ele) {
									# code...
							?>
							<tr>
								<td><?php echo $ele["ideleccion"]; ?></td>
								<td><?php echo $ele["desc_eleccion"]; ?></td>
								<td><?php echo $ele["estado"]; ?></td>
								<td><a href="<?php echo base_url('elecciones/form_ver/'. $ele["ideleccion"]); ?>"><span class="glyphicon glyphicon-search"></span></a></td>
								<td><?php if($ele["estado"] == 'ABIERTA'){ ?><a href="<?php echo base_url('elecciones/form_editar/'. $ele["ideleccion"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a><?php } ?></td>
								<td><?php if($ele["estado"] == 'ABIERTA'){ ?><a href="<?php echo base_url('elecciones/cerrar_eleccion/'. $ele["ideleccion"]); ?>"><span class="glyphicon glyphicon-ok"></span></a><?php } ?></td>
								<td><?php if($ele["estado"] == 'ABIERTA'){ ?><a href="<?php echo base_url('elecciones/eliminar_eleccion/'. $ele["ideleccion"]); ?>"><span class="glyphicon glyphicon-trash"></span></a><?php } ?></td>
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
			    	url:"<?php echo base_url('elecciones/get_elecciones_criterio'); ?>",
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
						html += "<th>Descripcion</th>";
						html += "<th>Estado</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].ideleccion + "</td>";
								html +=	"<td>" + json[datos].desc_eleccion + "</td>";
								html +=	"<td>" + json[datos].estado + "</td>";
								html +=	"<td><a href='<?php echo base_url('elecciones/form_ver/" + json[datos].ideleccion  + "'); ?>'><span class='glyphicon glyphicon-search'></span></a></td>";
								html +=	"<td>";
								if (json[datos].estado == 'ABIERTA') { 
									html +=	"<a href='<?php echo base_url('elecciones/form_editar/" + json[datos].ideleccion  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								}
								html += "</td>";
								html +=	"<td>";
								if (json[datos].estado == 'ABIERTA') { 
									html +=	"<a href='<?php echo base_url('elecciones/cerrar_eleccion/" + json[datos].ideleccion  + "'); ?>'><span class='glyphicon glyphicon-ok'></span></a></td>";
								}
								html += "</td>";
								html +=	"<td>";
								if (json[datos].estado == 'ABIERTA') { 
									html +=	"<a href='<?php echo base_url('elecciones/eliminar_eleccion/" + json[datos].ideleccion  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
								}
								html += "</td>";
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