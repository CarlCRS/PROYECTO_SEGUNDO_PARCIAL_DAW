<?php
session_start();

require_once __DIR__ . "/../app/controllers/AuthController.php";
require_once __DIR__ . "/../app/controllers/PacienteController.php";
require_once __DIR__ . "/../app/controllers/AntecedenteController.php";
require_once __DIR__ . "/../app/controllers/MedicoController.php";
require_once __DIR__ . "/../app/controllers/HorarioController.php";
require_once __DIR__ . "/../app/controllers/EspecialidadController.php";
require_once __DIR__ . "/../app/controllers/ServicioController.php";
require_once __DIR__ . "/../app/controllers/CitaController.php";
require_once __DIR__ . "/../app/controllers/PagoController.php";

function requiereAuth()
{
    if (!isset($_SESSION["usuario"])) {
        header("Location: ?url=auth/login&msg=" . urlencode("Debe iniciar sesion primero"));
        exit;
    }
}

function requiereAdmin()
{
    requiereAuth();
    if ($_SESSION["rol"] !== "admin") {
        header("Location: ?url=inicio&msg=" . urlencode("Acceso denegado"));
        exit;
    }
}

function requiereMedico()
{
    requiereAuth();
    if ($_SESSION["rol"] !== "medico") {
        header("Location: ?url=inicio&msg=" . urlencode("Acceso denegado"));
        exit;
    }
}

$url = $_GET["url"] ?? "auth/login";

switch ($url) {
        /* ---- Auth ---- */
    case "auth/login":
        $controller = new AuthController();
        $controller->login();
        $errores = [];
        require __DIR__ . "/../app/views/auth/login.php";
        break;

    case "auth/autenticar":
        $controller = new AuthController();
        $resultado = $controller->autenticar();
        if (isset($resultado["errores"])) {
            $errores = $resultado["errores"];
            require __DIR__ . "/../app/views/auth/login.php";
        }
        break;

    case "auth/registro":
        $controller = new AuthController();
        $controller->registro();
        $errores = [];
        require __DIR__ . "/../app/views/auth/registro.php";
        break;

    case "auth/registrar":
        $controller = new AuthController();
        $resultado = $controller->registrar();
        if (isset($resultado["errores"])) {
            $errores = $resultado["errores"];
            require __DIR__ . "/../app/views/auth/registro.php";
        }
        break;

    case "auth/logout":
        $controller = new AuthController();
        $controller->logout();
        break;

        /* ---- Inicio ---- */
    case "inicio":
        requiereAuth();
        require __DIR__ . "/../app/views/inicio/index.php";
        break;

        /* ---- Pacientes ---- */
    case "pacientes/listar":
        requiereAdmin();
        $controller = new PacienteController();
        $pacientes = $controller->listar();
        require __DIR__ . "/../app/views/pacientes/listar.php";
        break;

    case "pacientes/crear":
        requiereAdmin();
        $controller = new PacienteController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        $listaUsuarios = $data["usuarios"];
        require __DIR__ . "/../app/views/pacientes/formulario.php";
        break;

    case "pacientes/guardar":
        requiereAdmin();
        $controller = new PacienteController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaUsuarios = $resultado["usuarios"];
            require __DIR__ . "/../app/views/pacientes/formulario.php";
        }
        break;

    case "pacientes/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new PacienteController();
        $paciente = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $paciente;
        $listaUsuarios = $paciente["usuarios"];
        require __DIR__ . "/../app/views/pacientes/formulario.php";
        break;

    case "pacientes/actualizar":
        requiereAdmin();
        $controller = new PacienteController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaUsuarios = $resultado["usuarios"];
            $paciente = $datos;
            require __DIR__ . "/../app/views/pacientes/formulario.php";
        }
        break;

    case "pacientes/eliminar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new PacienteController();
        $controller->eliminar($id);
        break;

        /* ---- Antecedentes ---- */
    case "antecedentes/listar":
        requiereAdmin();
        $paciente_id = intval($_GET["paciente_id"] ?? 0);
        $controller = new AntecedenteController();
        $antecedentes = $controller->listar($paciente_id);
        $paciente = Paciente::obtenerPorId($paciente_id);
        $paciente_nombre = $paciente["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/antecedentes/listar.php";
        break;

    case "antecedentes/crear":
        requiereAdmin();
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
        requiereAdmin();
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
        requiereAdmin();
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
        requiereAdmin();
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
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new AntecedenteController();
        $controller->eliminar($id);
        break;

        /* ---- Medicos ---- */
    case "medicos/listar":
        requiereAdmin();
        $controller = new MedicoController();
        $medicos = $controller->listar();
        require __DIR__ . "/../app/views/medicos/listar.php";
        break;

    case "medicos/crear":
        requiereAdmin();
        $controller = new MedicoController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        $listaEspecialidades = $data["especialidades"];
        require __DIR__ . "/../app/views/medicos/formulario.php";
        break;

    case "medicos/guardar":
        requiereAdmin();
        $controller = new MedicoController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaEspecialidades = $resultado["especialidades"];
            require __DIR__ . "/../app/views/medicos/formulario.php";
        }
        break;

    case "medicos/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new MedicoController();
        $medico = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $medico;
        $listaEspecialidades = $medico["especialidades"];
        require __DIR__ . "/../app/views/medicos/formulario.php";
        break;

    case "medicos/actualizar":
        requiereAdmin();
        $controller = new MedicoController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaEspecialidades = $resultado["especialidades"];
            $medico = $datos;
            require __DIR__ . "/../app/views/medicos/formulario.php";
        }
        break;

    case "medicos/eliminar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new MedicoController();
        $controller->eliminar($id);
        break;

        /* ---- Horarios ---- */
    case "horarios/listar":
        requiereAdmin();
        $medico_id = intval($_GET["medico_id"] ?? 0);
        $controller = new HorarioController();
        $horarios = $controller->listar($medico_id);
        $medico = Medico::obtenerPorId($medico_id);
        $medico_nombre = $medico["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/horarios/listar.php";
        break;

    case "horarios/crear":
        requiereAdmin();
        $medico_id = intval($_GET["medico_id"] ?? 0);
        $controller = new HorarioController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["medico_id" => $medico_id, "dia_semana" => "", "hora_inicio" => "", "hora_fin" => ""];
        $listaMedicos = $data["medicos"];
        require __DIR__ . "/../app/views/horarios/formulario.php";
        break;

    case "horarios/guardar":
        requiereAdmin();
        $controller = new HorarioController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaMedicos = $resultado["medicos"];
            require __DIR__ . "/../app/views/horarios/formulario.php";
        }
        break;

    case "horarios/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new HorarioController();
        $horario = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $horario;
        $listaMedicos = $horario["medicos"];
        require __DIR__ . "/../app/views/horarios/formulario.php";
        break;

    case "horarios/actualizar":
        requiereAdmin();
        $controller = new HorarioController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaMedicos = $resultado["medicos"];
            $horario = $datos;
            require __DIR__ . "/../app/views/horarios/formulario.php";
        }
        break;

    case "horarios/eliminar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new HorarioController();
        $controller->eliminar($id);
        break;

        /* ---- Especialidades ---- */
    case "especialidades/listar":
        requiereAdmin();
        $controller = new EspecialidadController();
        $especialidades = $controller->listar();
        require __DIR__ . "/../app/views/especialidades/listar.php";
        break;

    case "especialidades/crear":
        requiereAdmin();
        $controller = new EspecialidadController();
        $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        require __DIR__ . "/../app/views/especialidades/formulario.php";
        break;

    case "especialidades/guardar":
        requiereAdmin();
        $controller = new EspecialidadController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            require __DIR__ . "/../app/views/especialidades/formulario.php";
        }
        break;

    case "especialidades/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new EspecialidadController();
        $especialidad = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $especialidad;
        require __DIR__ . "/../app/views/especialidades/formulario.php";
        break;

    case "especialidades/actualizar":
        requiereAdmin();
        $controller = new EspecialidadController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $especialidad = $datos;
            require __DIR__ . "/../app/views/especialidades/formulario.php";
        }
        break;

    case "especialidades/eliminar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new EspecialidadController();
        $controller->eliminar($id);
        break;

        /* ---- Servicios ---- */
    case "servicios/listar":
        requiereAdmin();
        $especialidad_id = intval($_GET["especialidad_id"] ?? 0);
        $controller = new ServicioController();
        $servicios = $controller->listar($especialidad_id);
        $especialidad = Especialidad::obtenerPorId($especialidad_id);
        $especialidad_nombre = $especialidad["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/servicios/listar.php";
        break;

    case "servicios/crear":
        requiereAdmin();
        $especialidad_id = intval($_GET["especialidad_id"] ?? 0);
        $controller = new ServicioController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["especialidad_id" => $especialidad_id, "nombre" => "", "tarifa" => ""];
        $listaEspecialidades = $data["especialidades"];
        require __DIR__ . "/../app/views/servicios/formulario.php";
        break;

    case "servicios/guardar":
        requiereAdmin();
        $controller = new ServicioController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaEspecialidades = $resultado["especialidades"];
            require __DIR__ . "/../app/views/servicios/formulario.php";
        }
        break;

    case "servicios/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new ServicioController();
        $servicio = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $servicio;
        $listaEspecialidades = $servicio["especialidades"];
        require __DIR__ . "/../app/views/servicios/formulario.php";
        break;

    case "servicios/actualizar":
        requiereAdmin();
        $controller = new ServicioController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaEspecialidades = $resultado["especialidades"];
            $servicio = $datos;
            require __DIR__ . "/../app/views/servicios/formulario.php";
        }
        break;

    case "servicios/eliminar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new ServicioController();
        $controller->eliminar($id);
        break;

        /* ---- Citas ---- */
    case "citas/listar":
        requiereAuth();
        $controller = new CitaController();
        $citas = $controller->listar();
        require __DIR__ . "/../app/views/citas/listar.php";
        break;

    case "citas/medico":
        requiereMedico();
        $controller = new CitaController();
        $citas = $controller->listarMedico();
        require __DIR__ . "/../app/views/citas/listar.php";
        break;

    case "citas/crear":
        requiereAuth();
        $controller = new CitaController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["paciente_id" => "", "medico_id" => "", "fecha" => "", "hora" => "", "motivo" => ""];
        $listaPacientes = $data["pacientes"] ?? [];
        $paciente_id = $data["paciente_id"] ?? 0;
        $listaMedicos = $data["medicos"];
        require __DIR__ . "/../app/views/citas/formulario.php";
        break;

    case "citas/guardar":
        requiereAuth();
        $controller = new CitaController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"] ?? [];
            $listaMedicos = $resultado["medicos"];
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            $paciente_id = $paciente["id"] ?? 0;
            require __DIR__ . "/../app/views/citas/formulario.php";
        }
        break;

    case "citas/editar":
        requiereAuth();
        $id = intval($_GET["id"] ?? 0);
        $controller = new CitaController();
        $cita = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $cita;
        $listaPacientes = $cita["pacientes"] ?? [];
        $listaMedicos = $cita["medicos"];
        require __DIR__ . "/../app/views/citas/formulario.php";
        break;

    case "citas/actualizar":
        requiereAuth();
        $controller = new CitaController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"] ?? [];
            $listaMedicos = $resultado["medicos"];
            $cita = $datos;
            require __DIR__ . "/../app/views/citas/formulario.php";
        }
        break;

    case "citas/eliminar":
        requiereAuth();
        $id = intval($_GET["id"] ?? 0);
        $controller = new CitaController();
        $controller->eliminar($id);
        break;

        /* ---- Pagos ---- */
    case "pagos/listar":
        requiereAuth();
        $cita_id = intval($_GET["cita_id"] ?? 0);
        $cita_info = Cita::obtenerPorId($cita_id);
        if (!$cita_info) {
            header("Location: ?url=citas/listar&msg=" . urlencode("Cita no encontrada"));
            exit;
        }
        if ($_SESSION["rol"] !== "admin") {
            $paciente = Paciente::obtenerPorUsuarioId($_SESSION["id_usuario"]);
            if (!$paciente || intval($cita_info["paciente_id"]) !== intval($paciente["id"])) {
                header("Location: ?url=citas/listar&msg=" . urlencode("No puedes ver pagos de otros pacientes"));
                exit;
            }
        }
        $controller = new PagoController();
        $pagos = $controller->listar($cita_id);
        require __DIR__ . "/../app/views/pagos/listar.php";
        break;

    case "pagos/editar":
        requiereAdmin();
        $id = intval($_GET["id"] ?? 0);
        $controller = new PagoController();
        $pago = $controller->editar($id);
        $errores = [];
        $datos = [];
        require __DIR__ . "/../app/views/pagos/formulario.php";
        break;

    case "pagos/actualizar":
        requiereAdmin();
        $controller = new PagoController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $pago = Pago::obtenerPorId(intval($_POST["id"] ?? 0));
            require __DIR__ . "/../app/views/pagos/formulario.php";
        }
        break;

    default:
        http_response_code(404);
        echo "404 - Pagina no encontrada";
}
