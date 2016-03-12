<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-fileinput.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jasny-bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sub-menus.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/number-format.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

	<style>
		.ui-autocomplete-loading {
	    background: white url("<?php echo base_url(); ?>assets/img/ajax-loader-small.gif") right center no-repeat;
	  	}
  	</style>

</head>
<body>
	
	<header>
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
						<span class="sr-only">Desplegar / Ocultar Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="<?php echo base_url(); ?>home" class="navbar-brand">ElectionSys</a>
				</div>
				<div class="collapse navbar-collapse" id="menu">
					<ul class="nav navbar-nav">
						<li class="active"><a href="<?php echo base_url(); ?>home">Inicio</a></li>

						<?php
							if($this->session->userdata('sess_perfil') == 1){
						?>

						<li class="menu-item dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador <span class="caret"></span></a>
							<ul class="dropdown-menu">
					           	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>usuarios/form_crear">Crear Usuario</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>usuarios/form_buscar">Editar Usuarios</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Elecciones</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>elecciones/form_crear">Crear Eleccion</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>elecciones/form_buscar">Editar Elecciones</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cursos</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>cursos/form_crear">Crear Curso</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>cursos/form_buscar">Editar Cursos</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Curules</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>curules/form_crear">Crear Curul</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>curules/form_buscar">Editar Curules</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>curules/form_asignar">Asignar Curules a Elecciones</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Estudiantes</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>estudiantes/form_crear">Crear Estudiante</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>estudiantes/form_buscar">Editar Estudiantes</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>estudiantes/form_importar">Importar Estudiantes</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Candidatos</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>candidatos/form_crear">Crear Candidato</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>candidatos/form_buscar">Editar Candidatos</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Votantes</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>votantes/form_crear">Crear Votantes</a></li>
		                            </ul>
	                        	</li>
				          	</ul>				
						</li>
						<li class="menu-item dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes <span class="caret"></span></a>
							<ul class="dropdown-menu">
					           	<li class="menu-item "><a href="<?php echo base_url(); ?>reportes/form_planilla">Planilla de Votantes</a></li>
		                        <li role="separator" class="divider"></li>
		                        <li class="menu-item "><a href="<?php echo base_url(); ?>reportes/form_resultado">Resultado de Votos</a></li>
				          	</ul>				
						</li>

						<?php
							}
						?>
						
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('sess_name_user'); ?><span class="caret"></span></a>
							<ul class="dropdown-menu">
					            <li><a href="<?php echo base_url(); ?>login/logout"><strong>Cerrar Sesion </strong><span class="glyphicon glyphicon-off"></span></a></li>
				          	</ul>				
						</li>
      				</ul>
				</div>
			</div>
		</nav>
	</header>