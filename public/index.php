<?php
require_once __DIR__ . "/../app/controllers/PacienteController.php";
require_once __DIR__ . "/../app/controllers/AntecedenteController.php";
require_once __DIR__ . "/../app/controllers/MedicoController.php";
require_once __DIR__ . "/../app/controllers/HorarioController.php";
require_once __DIR__ . "/../app/controllers/EspecialidadController.php";
require_once __DIR__ . "/../app/controllers/ServicioController.php";
require_once __DIR__ . "/../app/controllers/CitaController.php";
require_once __DIR__ . "/../app/controllers/PagoController.php";
require_once __DIR__ . "/../app/models/Especialidad.php";

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

        /* ---- Medicos ---- */
    case "medicos/listar":
        $controller = new MedicoController();
        $medicos = $controller->listar();
        require __DIR__ . "/../app/views/medicos/listar.php";
        break;

    case "medicos/crear":
        $controller = new MedicoController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        $listaEspecialidades = $data["especialidades"];
        require __DIR__ . "/../app/views/medicos/formulario.php";
        break;

    case "medicos/guardar":
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
        $id = intval($_GET["id"] ?? 0);
        $controller = new MedicoController();
        $controller->eliminar($id);
        break;

        /* ---- Horarios ---- */
    case "horarios/listar":
        $medico_id = intval($_GET["medico_id"] ?? 0);
        $controller = new HorarioController();
        $horarios = $controller->listar($medico_id);
        $medico = Medico::obtenerPorId($medico_id);
        $medico_nombre = $medico["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/horarios/listar.php";
        break;

    case "horarios/crear":
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
        $id = intval($_GET["id"] ?? 0);
        $controller = new HorarioController();
        $controller->eliminar($id);
        break;

        /* ---- Especialidades ---- */
    case "especialidades/listar":
        $controller = new EspecialidadController();
        $especialidades = $controller->listar();
        require __DIR__ . "/../app/views/especialidades/listar.php";
        break;

    case "especialidades/crear":
        $controller = new EspecialidadController();
        $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = [];
        require __DIR__ . "/../app/views/especialidades/formulario.php";
        break;

    case "especialidades/guardar":
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
        $id = intval($_GET["id"] ?? 0);
        $controller = new EspecialidadController();
        $especialidad = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $especialidad;
        require __DIR__ . "/../app/views/especialidades/formulario.php";
        break;

    case "especialidades/actualizar":
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
        $id = intval($_GET["id"] ?? 0);
        $controller = new EspecialidadController();
        $controller->eliminar($id);
        break;

        /* ---- Servicios ---- */
    case "servicios/listar":
        $especialidad_id = intval($_GET["especialidad_id"] ?? 0);
        $controller = new ServicioController();
        $servicios = $controller->listar($especialidad_id);
        $especialidad = Especialidad::obtenerPorId($especialidad_id);
        $especialidad_nombre = $especialidad["nombre"] ?? "Desconocido";
        require __DIR__ . "/../app/views/servicios/listar.php";
        break;

    case "servicios/crear":
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
        $id = intval($_GET["id"] ?? 0);
        $controller = new ServicioController();
        $controller->eliminar($id);
        break;

        /* ---- Citas ---- */
    case "citas/listar":
        $controller = new CitaController();
        $citas = $controller->listar();
        require __DIR__ . "/../app/views/citas/listar.php";
        break;

    case "citas/crear":
        $controller = new CitaController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["paciente_id" => "", "medico_id" => "", "fecha" => "", "hora" => "", "motivo" => ""];
        $listaPacientes = $data["pacientes"];
        $listaMedicos = $data["medicos"];
        require __DIR__ . "/../app/views/citas/formulario.php";
        break;

    case "citas/guardar":
        $controller = new CitaController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"];
            $listaMedicos = $resultado["medicos"];
            require __DIR__ . "/../app/views/citas/formulario.php";
        }
        break;

    case "citas/editar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new CitaController();
        $cita = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $cita;
        $listaPacientes = $cita["pacientes"];
        $listaMedicos = $cita["medicos"];
        require __DIR__ . "/../app/views/citas/formulario.php";
        break;

    case "citas/actualizar":
        $controller = new CitaController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaPacientes = $resultado["pacientes"];
            $listaMedicos = $resultado["medicos"];
            $cita = $datos;
            require __DIR__ . "/../app/views/citas/formulario.php";
        }
        break;

    case "citas/eliminar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new CitaController();
        $controller->eliminar($id);
        break;

        /* ---- Pagos ---- */
    case "pagos/listar":
        $cita_id = intval($_GET["cita_id"] ?? 0);
        $controller = new PagoController();
        $pagos = $controller->listar($cita_id);
        $cita_info = Cita::obtenerPorId($cita_id);
        require __DIR__ . "/../app/views/pagos/listar.php";
        break;

    case "pagos/crear":
        $cita_id = intval($_GET["cita_id"] ?? 0);
        $controller = new PagoController();
        $data = $controller->crear();
        $esEdicion = false;
        $errores = [];
        $datos = ["cita_id" => $cita_id, "monto" => "", "metodo_pago" => "", "fecha_pago" => date("Y-m-d")];
        $listaCitas = $data["citas"];
        require __DIR__ . "/../app/views/pagos/formulario.php";
        break;

    case "pagos/guardar":
        $controller = new PagoController();
        $resultado = $controller->guardar();
        if (isset($resultado["errores"])) {
            $esEdicion = false;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaCitas = $resultado["citas"];
            require __DIR__ . "/../app/views/pagos/formulario.php";
        }
        break;

    case "pagos/editar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new PagoController();
        $pago = $controller->editar($id);
        $esEdicion = true;
        $errores = [];
        $datos = $pago;
        $listaCitas = $pago["citas"];
        require __DIR__ . "/../app/views/pagos/formulario.php";
        break;

    case "pagos/actualizar":
        $controller = new PagoController();
        $resultado = $controller->actualizar();
        if (isset($resultado["errores"])) {
            $esEdicion = true;
            $errores = $resultado["errores"];
            $datos = $resultado["datos"];
            $listaCitas = $resultado["citas"];
            $pago = $datos;
            require __DIR__ . "/../app/views/pagos/formulario.php";
        }
        break;

    case "pagos/eliminar":
        $id = intval($_GET["id"] ?? 0);
        $controller = new PagoController();
        $controller->eliminar($id);
        break;

    default:
        http_response_code(404);
        echo "404 - Pagina no encontrada";
}
