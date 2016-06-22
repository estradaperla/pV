<?php
	include 'modelo.php';
	session_start();

	if (isset($_GET["desabilitarSis"])) {
		$resultadoDestuccion = session_destroy();
		if ($resultadoDestuccion)
			echo true;
		else
			echo false;
	}

	if (isset($_GET["usuario"]) && isset($_GET["password"]) && isset($_GET["tipo"])) {
		$typeUser = (int)$_GET["tipo"]; 
		$libreria = new Tienda();

		$result = $libreria->loginUsuario($_GET["usuario"], $_GET["password"], $typeUser);

		if ($result == 1){
			$_SESSION["usuarioValido"] = true;
			echo 1;
		}
		if ($result == 2){
			$_SESSION["usuarioValidoAdmin"] = true;
			echo 2;
		}
	}

	if (isset($_GET["verificar"])) {
		if (isset($_SESSION["usuarioValido"]))
			echo true;
		else 
			echo false;
	}

	if (isset($_GET['iniciarTienda'])) {
		$libreria = new Tienda();
		$_SESSION["libreriaa"] = $libreria;
	}

	if (isset($_GET['diaReporte'])) {
		$libreria = $_SESSION["libreriaa"];
		$diaReporte = $_GET['diaReporte'];
		$reportes = $libreria->getReporteDiario($diaReporte);
		echo json_encode($reportes);
	}
	if (isset($_GET['diaReporteCompra'])) {
		$libreria = $_SESSION["libreriaa"];
		$diaReporte = $_GET['diaReporteCompra'];
		$reportes = $libreria->getReporteDiarioCompras($diaReporte);
		echo json_encode($reportes);
	}
	

	if (isset($_GET["deleteReporte"])) {
		$libreria = $_SESSION["libreriaa"];
		$posicionEliminar = (int)$_GET["deleteReporte"];
		$libreria->deleteReporte($posicionEliminar);
		$resultado = $libreria->deleteReporte($libreria->reportesA[$posicionEliminar]['idDetalleVenta']);
		if ($resultado){
			unset($libreria->reportesA[$posicionEliminar]);
			echo true;
		} 	
		else
			echo false;
	}

	if (isset($_GET["updateReporte"]) && isset($_GET["nuevaCantidadComprada"])) {
		$libreria = $_SESSION["libreriaa"];
		$posicionModificar = (int)$_GET["updateReporte"];
		$cantidadModificar = (int)$_GET["nuevaCantidadComprada"];
		$resultado = $libreria->updateReporte($libreria->reportesA[$posicionModificar]['idDetalleVenta'], $cantidadModificar);

		echo json_encode($resultado);
	}

	if (isset($_GET["updateReporteCompra"]) && isset($_GET["nuevaCantidadComprada"])) {
		$libreria = $_SESSION["libreriaa"];
		$posicionModificar = (int)$_GET["updateReporteCompra"];
		$cantidadModificar = (int)$_GET["nuevaCantidadComprada"];
		$resultado = $libreria->updateReporteCompra($libreria->reportesA[$posicionModificar]['idDetalleVenta'], $cantidadModificar);

		echo json_encode($resultado);
	}

	if (isset($_GET["deleteCategoria"])) {
		$idCategoriaDelete = (int)$_GET["deleteCategoria"];
		$libreria = new Tienda();

		$statusDelete = $libreria->deleteCategoria($idCategoriaDelete);

		echo "$statusDelete";
	}
	if (isset($_GET["deleteMarca"])) {
		$idMarcaDelete = (int)$_GET["deleteMarca"];
		$libreria = new Tienda();

		$statusDelete = $libreria->deleteMarca($idMarcaDelete);

		echo "$statusDelete";
	}
	if (isset($_GET["deleteProveedor"])) {
		$idProveedorDelete = (int)$_GET["deleteProveedor"];
		$libreria = new Tienda();

		$statusDelete = $libreria->deleteProveedor($idProveedorDelete);

		echo "$statusDelete";
	}
?>