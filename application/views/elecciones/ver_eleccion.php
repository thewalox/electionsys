	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Elecciones</a></li>
						<li class="active">Ver Eleccion</li>
					</ol>
				</div>
				
				<?php
				if (!empty($eleccion)) {
				?>
				<form name="form">
					<div class="form-group" id="content"></div>

					<div class="panel panel-primary">
						<div class="panel-heading">Editar Eleccion</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-4">
									<label for="codigo">Codigo</label>
									<input type="text" placeholder="Codigo Eleccion" id="codigo" name="codigo" value="<?php echo $eleccion->ideleccion; ?>" class="form-control input-sm" disabled>
								</div>
					  			<div class="form-group col-md-4">
									<label for="fecini">Fecha Inicial</label>
									<div class='input-group date' id='datetimepicker1'>
						                <input type='text' class="form-control input-sm" name="fecini" id="fecini" value="<?php echo $eleccion->fecha_inicio; ?>" disabled/>
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
								<div class="form-group col-md-4">
									<label for="fecfin">Fecha Final</label>
									<div class='input-group date' id='datetimepicker2'>
						                <input type='text' class="form-control input-sm" name="fecfin" id="fecfin" value="<?php echo $eleccion->fecha_fin; ?>" disabled/>
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
					  		</div>
					  		<div class="row">
					  			<div class="form-group col-md-12">
									<label for="descripcion">Descripcion</label>
									<input type="text" placeholder="Descripcion" id="descripcion" name="descripcion" value="<?php echo $eleccion->desc_eleccion; ?>" class="form-control input-sm" disabled>
								</div>
					  		</div>
							<div class="row" align="center">
								<div class="col-md-12">
									<input type="button" name="cancelar" id="cancelar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'elecciones/form_buscar'; ?>';">
								</div>
					  		</div>
					
							
						</div>
					</div>
				</form>
				<?php
				}else{
				?>	
					<div class='alert alert-danger text-center' role='alert'>No existe eleccion con este criterio de busqueda o ya se encuentra en estado CERRADA.</div>
				<?php
				}
				?>
			</section>

		</div>
	</section>