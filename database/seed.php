<?php
/**
 * Seed script: Poblado de datos coherentes para el Sistema de Gestión de Citas Médicas
 */

require __DIR__ . "/../config/conexion.php";

$db = obtenerConexion();
$db->beginTransaction();

try {

    // ============================================================
    // 1. USUARIOS (médicos y pacientes)
    // ============================================================
    $usuarios = [
        // Médicos
        ["nombre" => "Dr. Ricardo Mendoza",     "email" => "ricardo.mendoza@clinica.com",  "password" => password_hash("medico123", PASSWORD_DEFAULT),  "rol" => "medico"],
        ["nombre" => "Dra. Ana Lucia Torres",   "email" => "ana.torres@clinica.com",       "password" => password_hash("medico123", PASSWORD_DEFAULT),  "rol" => "medico"],
        ["nombre" => "Dr. Carlos Gutierrez",    "email" => "carlos.gutierrez@clinica.com", "password" => password_hash("medico123", PASSWORD_DEFAULT),  "rol" => "medico"],
        ["nombre" => "Dra. Maria Fernanda Lopez", "email" => "maria.lopez@clinica.com",   "password" => password_hash("medico123", PASSWORD_DEFAULT),  "rol" => "medico"],
        // Pacientes
        ["nombre" => "Juan Perez Lopez",        "email" => "juan.perez@email.com",         "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
        ["nombre" => "Maria Garcia Rodriguez",  "email" => "maria.garcia@email.com",       "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
        ["nombre" => "Pedro Hernandez Cruz",    "email" => "pedro.hernandez@email.com",    "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
        ["nombre" => "Laura Martinez Sanchez",  "email" => "laura.martinez@email.com",     "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
        ["nombre" => "Roberto Diaz Castillo",   "email" => "roberto.diaz@email.com",       "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
        ["nombre" => "Sofia Ramirez Gomez",     "email" => "sofia.ramirez@email.com",      "password" => password_hash("paciente123", PASSWORD_DEFAULT), "rol" => "paciente"],
    ];

    $stmtUser = $db->prepare("INSERT IGNORE INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    $userIdMap = [];
    $adminId = null;

    // Get existing admin user
    $row = $db->query("SELECT id FROM usuarios WHERE email = 'admin@clinica.com'")->fetch();
    $adminId = $row ? $row["id"] : null;

    foreach ($usuarios as $u) {
        // check if already exists
        $existing = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $existing->execute([$u["email"]]);
        $row = $existing->fetch();
        if ($row) {
            $userIdMap[$u["email"]] = $row["id"];
            echo "  Usuario ya existe: {$u["nombre"]} <{$u["email"]}> -> #{$row["id"]}\n";
            continue;
        }
        $stmtUser->execute([$u["nombre"], $u["email"], $u["password"], $u["rol"]]);
        $uid = $db->lastInsertId();
        $userIdMap[$u["email"]] = $uid;
        echo "  Usuario creado: {$u["nombre"]} <{$u["email"]}> -> #{$uid}\n";
    }

    // Map emails to user IDs for readability
    $uid = function ($email) use ($userIdMap) {
        return $userIdMap[$email] ?? null;
    };

    // ============================================================
    // 2. MÉDICOS
    // ============================================================
    $medicos = [
        ["nombre" => "Dr. Ricardo Mendoza",       "email" => "ricardo.mendoza@clinica.com",  "especialidad_id" => 1, "telefono" => "809-555-1001"],
        ["nombre" => "Dra. Ana Lucia Torres",     "email" => "ana.torres@clinica.com",       "especialidad_id" => 2, "telefono" => "809-555-1002"],
        ["nombre" => "Dr. Carlos Gutierrez",      "email" => "carlos.gutierrez@clinica.com", "especialidad_id" => 3, "telefono" => "809-555-1003"],
        ["nombre" => "Dra. Maria Fernanda Lopez", "email" => "maria.lopez@clinica.com",      "especialidad_id" => 4, "telefono" => "809-555-1004"],
    ];

    $stmtMed = $db->prepare("INSERT IGNORE INTO medicos (usuario_id, nombre, especialidad_id, telefono) VALUES (?, ?, ?, ?)");
    $medicoIdMap = [];

    foreach ($medicos as $m) {
        $existing = $db->prepare("SELECT id FROM medicos WHERE nombre = ?");
        $existing->execute([$m["nombre"]]);
        $row = $existing->fetch();
        if ($row) {
            $medicoIdMap[$m["nombre"]] = $row["id"];
            echo "  Medico ya existe: {$m["nombre"]} -> #{$row["id"]}\n";
            continue;
        }
        $stmtMed->execute([$uid($m["email"]), $m["nombre"], $m["especialidad_id"], $m["telefono"]]);
        $mid = $db->lastInsertId();
        $medicoIdMap[$m["nombre"]] = $mid;
        echo "  Medico creado: {$m["nombre"]} -> #{$mid}\n";
    }

    // ============================================================
    // 3. PACIENTES
    // ============================================================
    $pacientes = [
        ["nombre" => "Juan Perez Lopez",        "email" => "juan.perez@email.com",       "cedula" => "001-1234567-8", "telefono" => "829-555-2001", "fn" => "1985-03-15"],
        ["nombre" => "Maria Garcia Rodriguez",  "email" => "maria.garcia@email.com",     "cedula" => "001-2345678-9", "telefono" => "809-555-2002", "fn" => "1990-07-22"],
        ["nombre" => "Pedro Hernandez Cruz",    "email" => "pedro.hernandez@email.com",  "cedula" => "002-3456789-0", "telefono" => "849-555-2003", "fn" => "1978-11-08"],
        ["nombre" => "Laura Martinez Sanchez",  "email" => "laura.martinez@email.com",   "cedula" => "001-4567890-1", "telefono" => "829-555-2004", "fn" => "1995-01-30"],
        ["nombre" => "Roberto Diaz Castillo",   "email" => "roberto.diaz@email.com",     "cedula" => "003-5678901-2", "telefono" => "809-555-2005", "fn" => "1982-09-14"],
        ["nombre" => "Sofia Ramirez Gomez",     "email" => "sofia.ramirez@email.com",    "cedula" => "001-6789012-3", "telefono" => "849-555-2006", "fn" => "2000-05-20"],
    ];

    $stmtPac = $db->prepare("INSERT IGNORE INTO pacientes (usuario_id, nombre, cedula, telefono, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
    $pacienteIdMap = [];

    foreach ($pacientes as $p) {
        $existing = $db->prepare("SELECT id FROM pacientes WHERE cedula = ?");
        $existing->execute([$p["cedula"]]);
        $row = $existing->fetch();
        if ($row) {
            $pacienteIdMap[$p["nombre"]] = $row["id"];
            echo "  Paciente ya existe: {$p["nombre"]} (cedula: {$p["cedula"]}) -> #{$row["id"]}\n";
            continue;
        }
        $stmtPac->execute([$uid($p["email"]), $p["nombre"], $p["cedula"], $p["telefono"], $p["fn"]]);
        $pid = $db->lastInsertId();
        $pacienteIdMap[$p["nombre"]] = $pid;
        echo "  Paciente creado: {$p["nombre"]} -> #{$pid}\n";
    }

    // ============================================================
    // 4. SERVICIOS
    // ============================================================
    $servicios = [
        ["especialidad_id" => 1, "nombre" => "Consulta General",      "tarifa" => 800.00],
        ["especialidad_id" => 1, "nombre" => "Consulta de Control",   "tarifa" => 500.00],
        ["especialidad_id" => 2, "nombre" => "Consulta Pediatrica",   "tarifa" => 1000.00],
        ["especialidad_id" => 2, "nombre" => "Control de Nino Sano",  "tarifa" => 700.00],
        ["especialidad_id" => 2, "nombre" => "Vacunacion",            "tarifa" => 600.00],
        ["especialidad_id" => 3, "nombre" => "Limpieza Dental",       "tarifa" => 1200.00],
        ["especialidad_id" => 3, "nombre" => "Extraccion",            "tarifa" => 1500.00],
        ["especialidad_id" => 3, "nombre" => "Blanqueamiento",        "tarifa" => 2500.00],
        ["especialidad_id" => 4, "nombre" => "Consulta Dermatologica", "tarifa" => 1500.00],
        ["especialidad_id" => 4, "nombre" => "Revision de Lunares",   "tarifa" => 1200.00],
        ["especialidad_id" => 4, "nombre" => "Tratamiento de Acne",   "tarifa" => 1800.00],
    ];

    $stmtServ = $db->prepare("INSERT IGNORE INTO servicios (especialidad_id, nombre, tarifa) VALUES (?, ?, ?)");

    foreach ($servicios as $s) {
        $existing = $db->prepare("SELECT id FROM servicios WHERE nombre = ? AND especialidad_id = ?");
        $existing->execute([$s["nombre"], $s["especialidad_id"]]);
        if ($existing->fetch()) {
            echo "  Servicio ya existe: {$s["nombre"]}\n";
            continue;
        }
        $stmtServ->execute([$s["especialidad_id"], $s["nombre"], $s["tarifa"]]);
        echo "  Servicio creado: {$s["nombre"]} (\${$s["tarifa"]})\n";
    }

    // ============================================================
    // 5. HORARIOS
    // ============================================================
    // Formato: [nombre_medico, dia_semana, hora_inicio, hora_fin]
    $horariosData = [
        // Dr. Ricardo Mendoza - Medicina General -> Lun-Vie 8-12, 14-17
        ["Dr. Ricardo Mendoza", "lunes",    "08:00", "12:00"],
        ["Dr. Ricardo Mendoza", "lunes",    "14:00", "17:00"],
        ["Dr. Ricardo Mendoza", "martes",   "08:00", "12:00"],
        ["Dr. Ricardo Mendoza", "martes",   "14:00", "17:00"],
        ["Dr. Ricardo Mendoza", "miercoles","08:00", "12:00"],
        ["Dr. Ricardo Mendoza", "miercoles","14:00", "17:00"],
        ["Dr. Ricardo Mendoza", "jueves",   "08:00", "12:00"],
        ["Dr. Ricardo Mendoza", "jueves",   "14:00", "17:00"],
        ["Dr. Ricardo Mendoza", "viernes",  "08:00", "12:00"],
        ["Dr. Ricardo Mendoza", "viernes",  "14:00", "17:00"],
        // Dra. Ana Lucia Torres - Pediatria -> Lun-Vie 9-13, 15-18
        ["Dra. Ana Lucia Torres", "lunes",    "09:00", "13:00"],
        ["Dra. Ana Lucia Torres", "lunes",    "15:00", "18:00"],
        ["Dra. Ana Lucia Torres", "martes",   "09:00", "13:00"],
        ["Dra. Ana Lucia Torres", "martes",   "15:00", "18:00"],
        ["Dra. Ana Lucia Torres", "miercoles","09:00", "13:00"],
        ["Dra. Ana Lucia Torres", "miercoles","15:00", "18:00"],
        ["Dra. Ana Lucia Torres", "jueves",   "09:00", "13:00"],
        ["Dra. Ana Lucia Torres", "jueves",   "15:00", "18:00"],
        ["Dra. Ana Lucia Torres", "viernes",  "09:00", "13:00"],
        ["Dra. Ana Lucia Torres", "viernes",  "15:00", "18:00"],
        // Dr. Carlos Gutierrez - Odontologia -> Lun-Sab 8-12, 14-17
        ["Dr. Carlos Gutierrez", "lunes",    "08:00", "12:00"],
        ["Dr. Carlos Gutierrez", "lunes",    "14:00", "17:00"],
        ["Dr. Carlos Gutierrez", "martes",   "08:00", "12:00"],
        ["Dr. Carlos Gutierrez", "martes",   "14:00", "17:00"],
        ["Dr. Carlos Gutierrez", "miercoles","08:00", "12:00"],
        ["Dr. Carlos Gutierrez", "miercoles","14:00", "17:00"],
        ["Dr. Carlos Gutierrez", "jueves",   "08:00", "12:00"],
        ["Dr. Carlos Gutierrez", "jueves",   "14:00", "17:00"],
        ["Dr. Carlos Gutierrez", "viernes",  "08:00", "12:00"],
        ["Dr. Carlos Gutierrez", "viernes",  "14:00", "17:00"],
        ["Dr. Carlos Gutierrez", "sabado",   "08:00", "12:00"],
        // Dra. Maria Fernanda Lopez - Dermatologia -> Mar-Sab 8-12, 14-16
        ["Dra. Maria Fernanda Lopez", "martes",   "08:00", "12:00"],
        ["Dra. Maria Fernanda Lopez", "martes",   "14:00", "16:00"],
        ["Dra. Maria Fernanda Lopez", "miercoles","08:00", "12:00"],
        ["Dra. Maria Fernanda Lopez", "miercoles","14:00", "16:00"],
        ["Dra. Maria Fernanda Lopez", "jueves",   "08:00", "12:00"],
        ["Dra. Maria Fernanda Lopez", "jueves",   "14:00", "16:00"],
        ["Dra. Maria Fernanda Lopez", "viernes",  "08:00", "12:00"],
        ["Dra. Maria Fernanda Lopez", "viernes",  "14:00", "16:00"],
        ["Dra. Maria Fernanda Lopez", "sabado",   "08:00", "12:00"],
    ];

    $stmtHor = $db->prepare("INSERT IGNORE INTO horarios (medico_id, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)");

    foreach ($horariosData as $h) {
        $medName = $h[0];
        $medId = $medicoIdMap[$medName] ?? null;
        if (!$medId) {
            echo "  ERROR: Medico no encontrado: $medName\n";
            continue;
        }
        $dia = $h[1];
        $hIni = $h[2];
        $hFin = $h[3];
        // check duplicate
        $existing = $db->prepare("SELECT id FROM horarios WHERE medico_id = ? AND dia_semana = ? AND hora_inicio = ? AND hora_fin = ?");
        $existing->execute([$medId, $dia, $hIni, $hFin]);
        if ($existing->fetch()) {
            continue;
        }
        $stmtHor->execute([$medId, $dia, $hIni, $hFin]);
        echo "  Horario creado: $medName - $dia $hIni-$hFin\n";
    }

    // ============================================================
    // 6. CITAS
    // ============================================================
    $citasData = [
        ["paciente" => "Juan Perez Lopez",       "medico" => "Dr. Ricardo Mendoza",     "fecha" => "2026-07-08", "hora" => "09:00", "estado" => "confirmada",  "motivo" => "Control de rutina"],
        ["paciente" => "Maria Garcia Rodriguez",  "medico" => "Dra. Ana Lucia Torres",    "fecha" => "2026-07-09", "hora" => "10:00", "estado" => "pendiente",   "motivo" => "Revision pediatrica"],
        ["paciente" => "Pedro Hernandez Cruz",    "medico" => "Dr. Carlos Gutierrez",     "fecha" => "2026-07-10", "hora" => "11:00", "estado" => "confirmada",  "motivo" => "Dolor de muela"],
        ["paciente" => "Laura Martinez Sanchez",  "medico" => "Dra. Maria Fernanda Lopez", "fecha" => "2026-07-08", "hora" => "14:00", "estado" => "pendiente",   "motivo" => "Revision dermatologica"],
        ["paciente" => "Juan Perez Lopez",        "medico" => "Dr. Carlos Gutierrez",     "fecha" => "2026-07-14", "hora" => "09:00", "estado" => "pendiente",   "motivo" => "Limpieza dental"],
        ["paciente" => "Roberto Diaz Castillo",   "medico" => "Dr. Ricardo Mendoza",     "fecha" => "2026-07-15", "hora" => "10:00", "estado" => "confirmada",  "motivo" => "Chequeo general"],
        ["paciente" => "Maria Garcia Rodriguez",  "medico" => "Dra. Ana Lucia Torres",    "fecha" => "2026-07-16", "hora" => "15:00", "estado" => "pendiente",   "motivo" => "Vacunacion"],
        ["paciente" => "Sofia Ramirez Gomez",     "medico" => "Dra. Maria Fernanda Lopez", "fecha" => "2026-07-17", "hora" => "09:00", "estado" => "pendiente",   "motivo" => "Consulta por acne"],
        // Algunas citas pasadas (atendidas) para tener historial
        ["paciente" => "Juan Perez Lopez",        "medico" => "Dr. Ricardo Mendoza",     "fecha" => "2026-06-24", "hora" => "09:00", "estado" => "atendida",    "motivo" => "Dolor de cabeza persistente"],
        ["paciente" => "Laura Martinez Sanchez",  "medico" => "Dra. Maria Fernanda Lopez", "fecha" => "2026-06-18", "hora" => "10:00", "estado" => "atendida",    "motivo" => "Alergia cutanea"],
        ["paciente" => "Pedro Hernandez Cruz",    "medico" => "Dr. Carlos Gutierrez",     "fecha" => "2026-06-22", "hora" => "11:00", "estado" => "cancelada",   "motivo" => "Revision de ortodoncia"],
        ["paciente" => "Roberto Diaz Castillo",   "medico" => "Dr. Ricardo Mendoza",     "fecha" => "2026-06-15", "hora" => "10:00", "estado" => "atendida",    "motivo" => "Dolor lumbar"],
        ["paciente" => "Maria Garcia Rodriguez",  "medico" => "Dra. Ana Lucia Torres",    "fecha" => "2026-06-10", "hora" => "10:30", "estado" => "atendida",    "motivo" => "Control pediatrico"],
        ["paciente" => "Sofia Ramirez Gomez",     "medico" => "Dr. Ricardo Mendoza",     "fecha" => "2026-06-29", "hora" => "11:00", "estado" => "atendida",    "motivo" => "Fiebre y malestar general"],
    ];

    $stmtCita = $db->prepare("INSERT IGNORE INTO citas (paciente_id, medico_id, fecha, hora, estado, motivo) VALUES (?, ?, ?, ?, ?, ?)");
    $citaIdMap = [];

    foreach ($citasData as $c) {
        $pacId = $pacienteIdMap[$c["paciente"]] ?? null;
        $medId = $medicoIdMap[$c["medico"]] ?? null;
        if (!$pacId || !$medId) {
            echo "  ERROR: Referencia no encontrada para cita: {$c["paciente"]} / {$c["medico"]}\n";
            continue;
        }
        // Check duplicate
        $existing = $db->prepare("SELECT id FROM citas WHERE paciente_id = ? AND medico_id = ? AND fecha = ? AND hora = ?");
        $existing->execute([$pacId, $medId, $c["fecha"], $c["hora"]]);
        if ($row = $existing->fetch()) {
            $key = $c["paciente"] . "|" . $c["medico"] . "|" . $c["fecha"] . "|" . $c["hora"];
            $citaIdMap[$key] = $row["id"];
            echo "  Cita ya existe: {$c["paciente"]} con {$c["medico"]} el {$c["fecha"]} a las {$c["hora"]} -> #{$row["id"]}\n";
            continue;
        }
        $stmtCita->execute([$pacId, $medId, $c["fecha"], $c["hora"], $c["estado"], $c["motivo"]]);
        $cid = $db->lastInsertId();
        $key = $c["paciente"] . "|" . $c["medico"] . "|" . $c["fecha"] . "|" . $c["hora"];
        $citaIdMap[$key] = $cid;
        echo "  Cita creada: {$c["paciente"]} con {$c["medico"]} el {$c["fecha"]} a las {$c["hora"]} ({$c["estado"]}) -> #{$cid}\n";
    }

    // ============================================================
    // 7. ANTECEDENTES
    // ============================================================
    $antecedentesData = [
        ["paciente" => "Juan Perez Lopez",       "descripcion" => "Hipertension arterial diagnosticada en 2020. Controlada con medicacion.",             "fecha" => "2020-03-10"],
        ["paciente" => "Juan Perez Lopez",       "descripcion" => "Apendicectomia realizada en 2018 sin complicaciones.",                               "fecha" => "2018-07-22"],
        ["paciente" => "Maria Garcia Rodriguez", "descripcion" => "Asma bronquial desde la infancia. Usa inhalador de rescate.",                         "fecha" => "2019-01-15"],
        ["paciente" => "Pedro Hernandez Cruz",   "descripcion" => "Diabetes tipo 2 diagnosticada en 2021. Controlada con metformina.",                  "fecha" => "2021-05-20"],
        ["paciente" => "Laura Martinez Sanchez", "descripcion" => "Alergia a la penicilina. No administrar antibioticos de este grupo.",                 "fecha" => "2020-09-12"],
        ["paciente" => "Roberto Diaz Castillo",  "descripcion" => "Cirugia de rodilla izquierda (reconstruccion de ligamentos) en 2022.",               "fecha" => "2022-11-03"],
        ["paciente" => "Sofia Ramirez Gomez",    "descripcion" => "Sin antecedentes patologicos de importancia. Paciente generalmente saludable.",      "fecha" => "2024-01-10"],
        ["paciente" => "Roberto Diaz Castillo",  "descripcion" => "Hiperlipidemia. En tratamiento con estatinas desde 2023.",                            "fecha" => "2023-04-18"],
        ["paciente" => "Maria Garcia Rodriguez", "descripcion" => "Rinitis alergica estacional. Controlada con antihistaminicos.",                       "fecha" => "2020-06-05"],
    ];

    $stmtAnt = $db->prepare("INSERT IGNORE INTO antecedentes (paciente_id, descripcion, fecha_registro) VALUES (?, ?, ?)");

    foreach ($antecedentesData as $a) {
        $pacId = $pacienteIdMap[$a["paciente"]] ?? null;
        if (!$pacId) {
            echo "  ERROR: Paciente no encontrado: {$a["paciente"]}\n";
            continue;
        }
        $stmtAnt->execute([$pacId, $a["descripcion"], $a["fecha"]]);
        echo "  Antecedente creado: {$a["paciente"]} - {$a["descripcion"]}\n";
    }

    // ============================================================
    // 8. PAGOS (solo para citas confirmadas/atendidas)
    // ============================================================
    $pagosData = [
        // Pago para la cita confirmada de Juan Perez con Dr. Mendoza el 2026-07-08
        ["citaKey" => "Juan Perez Lopez|Dr. Ricardo Mendoza|2026-07-08|09:00",     "monto" => 800.00,  "estado" => "pagado", "metodo" => "efectivo",     "fecha" => "2026-07-08"],
        // Pago para la cita confirmada de Pedro Hernandez con Dr. Gutierrez el 2026-07-10
        ["citaKey" => "Pedro Hernandez Cruz|Dr. Carlos Gutierrez|2026-07-10|11:00", "monto" => 1500.00, "estado" => "pagado", "metodo" => "tarjeta",     "fecha" => "2026-07-10"],
        // Pago para la cita confirmada de Roberto Diaz con Dr. Mendoza el 2026-07-15
        ["citaKey" => "Roberto Diaz Castillo|Dr. Ricardo Mendoza|2026-07-15|10:00", "monto" => 800.00,  "estado" => "pagado", "metodo" => "transferencia", "fecha" => "2026-07-15"],
        // Pago para citas atendidas (pasadas)
        ["citaKey" => "Juan Perez Lopez|Dr. Ricardo Mendoza|2026-06-24|09:00",      "monto" => 800.00,  "estado" => "pagado", "metodo" => "efectivo",     "fecha" => "2026-06-24"],
        ["citaKey" => "Laura Martinez Sanchez|Dra. Maria Fernanda Lopez|2026-06-18|10:00", "monto" => 1500.00, "estado" => "pagado", "metodo" => "tarjeta", "fecha" => "2026-06-18"],
        ["citaKey" => "Roberto Diaz Castillo|Dr. Ricardo Mendoza|2026-06-15|10:00",  "monto" => 800.00,  "estado" => "pagado", "metodo" => "efectivo",     "fecha" => "2026-06-15"],
        ["citaKey" => "Maria Garcia Rodriguez|Dra. Ana Lucia Torres|2026-06-10|10:30", "monto" => 1000.00, "estado" => "pagado", "metodo" => "transferencia", "fecha" => "2026-06-10"],
        ["citaKey" => "Sofia Ramirez Gomez|Dr. Ricardo Mendoza|2026-06-29|11:00",    "monto" => 800.00,  "estado" => "pagado", "metodo" => "efectivo",     "fecha" => "2026-06-29"],
    ];

    $stmtPag = $db->prepare("INSERT IGNORE INTO pagos (cita_id, monto, estado_pago, metodo_pago, fecha_pago) VALUES (?, ?, ?, ?, ?)");

    foreach ($pagosData as $p) {
        $citaId = $citaIdMap[$p["citaKey"]] ?? null;
        if (!$citaId) {
            echo "  ERROR: Cita no encontrada: {$p["citaKey"]}\n";
            continue;
        }
        $existing = $db->prepare("SELECT id FROM pagos WHERE cita_id = ?");
        $existing->execute([$citaId]);
        if ($existing->fetch()) {
            echo "  Pago ya existe para cita #$citaId\n";
            continue;
        }
        $stmtPag->execute([$citaId, $p["monto"], $p["estado"], $p["metodo"], $p["fecha"]]);
        echo "  Pago creado: cita #$citaId - \${$p["monto"]} ({$p["estado"]} - {$p["metodo"]})\n";
    }

    $db->commit();
    echo "\n✅ SEED COMPLETADO EXITOSAMENTE\n";

} catch (Exception $e) {
    $db->rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
}
