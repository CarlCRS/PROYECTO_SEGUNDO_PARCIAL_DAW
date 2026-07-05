<?php
require_once __DIR__ . "/../app/controllers/PacienteController.php";
require_once __DIR__ . "/../app/controllers/AntecedenteController.php";

$url = $_GET["url"] ?? "inicio";

switch ($url) {
        /* ---- Inicio ---- */
    case "inicio":
        require __DIR__ . "/../app/views/inicio/index.php";
        break;

        /* ---- Pacientes ---- */
    case "pacientes/listar":
        $controller = new PacienteController();
        $pacientes = $controller->listar();
        require __DIR__ . "/../app/views/pacientes/listar.php";
        break;

    case "pacientes/crear":
        $controller = new PacienteController();
        $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        require __DIR__ . "/../app/views/pacientes/formulario.php";
        break;

    case "pacientes/guardar":
        $controller = new PacienteController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            require __DIR__ . "/../app/views/pacientes/formulario.php";
        }
        break;

    case "pacientes/editar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new PacienteController();
        $paciente = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $paciente;
        require __DIR__ . "/../app/views/pacientes/formulario.php";
        break;

    case "pacientes/actualizar":
        $controller = new PacienteController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $paciente = $datos;
            require __DIR__ . "/../app/views/pacientes/formulario.php";
        }
        break;

    case "pacientes/eliminar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new PacienteController();
        $controller->eliminar($id);
        break;

        /* ---- Antecedentes ---- */
    case "antecedentes/listar":
        $paciente_id = intval($_GET["paciente_id"] ?? 0);
        $controller = new AntecedenteController();
        $antecedentes = $controller->listar($paciente_id);
        $paciente = Paciente::obtenerPorId($paciente_id);
        $paciente_nombre = $paciente["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/antecedentes/listar.php";
        break;

    case "antecedentes/crear":
        $paciente_id = intval($_GET["paciente_id"] ?? 0);
        $controller = new AntecedenteController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["paciente_id" => $paciente_id, "descripcion" => "", "fecha_registro" => date("Y-m-d")];
        $listaPacientes = $data["pacientes"];
        require __DIR__ . "/../app/views/antecedentes/formulario.php";
        break;

    case "antecedentes/guardar":
        $controller = new AntecedenteController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"];
            require __DIR__ . "/../app/views/antecedentes/formulario.php";
        }
        break;

    case "antecedentes/editar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new AntecedenteController();
        $antecedente = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $antecedente;
        $listaPacientes = $antecedente["pacientes"];
        require __DIR__ . "/../app/views/antecedentes/formulario.php";
        break;

    case "antecedentes/actualizar":
        $controller = new AntecedenteController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"];
            $antecedente = $datos;
            require __DIR__ . "/../app/views/antecedentes/formulario.php";
        }
        break;

    case "antecedentes/eliminar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new AntecedenteController();
        $controller->eliminar($id);
        break;

    default:
        http_response_code(404);
        echo "404 - Pagina no encontrada";
}
