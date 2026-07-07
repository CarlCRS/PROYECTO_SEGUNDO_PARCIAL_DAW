# 🏥 Sistema de Gestion de Citas Medicas

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-Aiven-4479A1?style=flat&logo=mysql)](https://aiven.io)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)](https://docker.com)
[![Render](https://img.shields.io/badge/Deploy-Render-46E3B7?style=flat&logo=render)](https://render.com)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)]()

---

Aplicacion web para la gestion de citas medicas entre pacientes y medicos, desarrollada en **PHP + MySQL** siguiendo el patron de arquitectura **MVC**.

## 🚀 Demo en linea

[https://proyecto-segundo-parcial-daw-syip.onrender.com](https://proyecto-segundo-parcial-daw-syip.onrender.com)

---

## 📋 Tecnologias

| Capa | Tecnologia | Proposito |
|------|-----------|-----------|
| **Backend** | PHP 8.2 | Logica de negocio, controladores, sesiones |
| **Base de datos** | MySQL (Aiven) | Persistencia de datos |
| **Acceso a datos** | PDO | Conexion segura con sentencias preparadas |
| **Frontend** | HTML5 + CSS3 + JS | Interfaz de usuario y validaciones |
| **Contenedor** | Docker | Apache + PHP en produccion |
| **Despliegue** | Render | Hosting en la nube |

---

## 📁 Estructura del proyecto

```
/
├── public/               # Archivos publicos (raiz del servidor)
│   ├── index.php         # Front Controller
│   ├── css/estilos.css   # Hojas de estilo
│   └── js/script.js      # Scripts JavaScript
├── app/
│   ├── controllers/      # Logica de negocio
│   ├── models/           # Acceso a datos (Modelos)
│   └── views/            # Interfaz de usuario (Vistas)
│       ├── pacientes/    # CRUD Pacientes
│       ├── antecedentes/ # CRUD Antecedentes
│       └── layout/       # Header y Footer compartidos
├── config/
│   └── conexion.php      # Conexion PDO + carga de .env
├── database/
│   └── database.sql      # Script completo de la BD
├── Dockerfile            # Configuracion Docker para Render
├── .env.example          # Variables de entorno de ejemplo
├── .gitignore
└── README.md
```

---

## 💻 Instalacion local

### Requisitos
- PHP >= 8.0 con extensiones `pdo` y `pdo_mysql`
- MySQL 8.0 o MariaDB
- Git

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/CarlCRS/PROYECTO_SEGUNDO_PARCIAL_DAW.git
cd PROYECTO_SEGUNDO_PARCIAL_DAW

# 2. Crear la base de datos
mysql -u root -p < database/database.sql

# 3. Configurar credenciales
cp .env.example .env
# Editar .env con tus datos locales:
# DB_HOST=localhost
# DB_PORT=3306
# DB_NAME=citas_medicas
# DB_USER=root
# DB_PASS=

# 4. Iniciar servidor de desarrollo
php -S localhost:8000 -t public

# 5. Abrir en el navegador
http://localhost:8000
```

---

## 🔐 Usuario de prueba

| Rol | Correo | Contraseña |
|-----|--------|------------|
| Administrador | `admin@clinica.com` | `admin123` |

---

## 👥 Modulos del sistema

| Integrante | Entidad 1 | Entidad 2 | Relacion |
|-----------|-----------|-----------|----------|
| 1 | Pacientes | Antecedentes medicos | 1 paciente → N antecedentes |
| 2 | Medicos | Horarios de disponibilidad | 1 medico → N horarios |
| 3 | Especialidades | Servicios / Tarifas | 1 especialidad → N servicios |
| 4 | Citas | Pagos | 1 cita → 1 o mas pagos |

### Roles de usuario

| Rol | Acceso |
|-----|--------|
| 👑 **Administrador** | Acceso total al sistema |
| 🩺 **Medico** | Gestiona su propia agenda de citas |
| 👤 **Paciente** | Agenda y cancela sus citas, consulta historial |

---

## 🐳 Despliegue en Render

El proyecto utiliza **Docker** para el despliegue:

1. Conectar el repositorio a Render como **Web Service**
2. Seleccionar runtime: **Docker**
3. Configurar variables de entorno en Render:

| Variable | Valor |
|----------|-------|
| `DB_HOST` | Host de la base de datos |
| `DB_PORT` | Puerto de conexion |
| `DB_NAME` | Nombre de la base de datos |
| `DB_USER` | Usuario de la base de datos |
| `DB_PASS` | Contraseña |
| `DB_SSL` | `REQUIRED` (si aplica) |

> El `Dockerfile` configura Apache con PHP 8.2, habilita `mod_rewrite` y apunta la raiz a `/public`.

---

## Estado del proyecto

| Modulo               | Estado        | Integrante |
| -------------------- | ------------- | ---------- |
| Pacientes            | ✅ Completo   | 1          |
| Antecedentes medicos | ✅ Completo   | 1          |
| Medicos              | ✅ Completo   | 2          |
| Horarios             | ✅ Completo   | 2          |
| Especialidades       | ✅ Completo   | 3          |
| Servicios / Tarifas  | ✅ Completo   | 3          |
| Citas                | ✅ Completo   | 4          |
| Pagos                | ✅ Completo   | 4          |
| Autenticacion        | ⬜ Pendiente  | Equipo     |

## Modulos del sistema

| Caso | Entrada | Resultado esperado |
|------|---------|-------------------|
| Registrar paciente valido | Datos correctos | Paciente creado exitosamente |
| Registrar cedula duplicada | Cedula ya existente | Mensaje de error |
| Campos vacios | Formulario incompleto | Bloqueo frontend + backend |
| Editar paciente | Cambiar datos | Actualizacion correcta |
| Eliminar paciente | Confirmar eliminacion | Registro eliminado |

### Integrante 2 — Medicos y Horarios (CRUD completo)

**Medicos:**
- Listado de medicos con especialidad asociada (JOIN con `especialidades`)
- Registro de nuevo medico con seleccion de especialidad
- Edicion de datos del medico (nombre, especialidad, telefono)
- Eliminacion con validacion de citas activas pendientes/confirmadas

**Horarios de disponibilidad:**
- Listado de horarios por medico ordenados por dia y hora
- Registro de bloques horarios (dia de la semana, hora inicio, hora fin)
- Validacion: hora de fin debe ser posterior a hora de inicio
- Edicion y eliminacion de bloques de horario

**Rutas implementadas:** `medicos/listar`, `medicos/crear`, `medicos/guardar`, `medicos/editar`, `medicos/actualizar`, `medicos/eliminar`, `horarios/listar`, `horarios/crear`, `horarios/guardar`, `horarios/editar`, `horarios/actualizar`, `horarios/eliminar`

### Integrante 3 — Especialidades y Servicios (CRUD completo)

**Especialidades:**
- Listado de todas las especialidades medicas registradas
- Registro de nueva especialidad
- Edicion del nombre de la especialidad
- Eliminacion con validacion: no permite borrar si hay medicos o servicios asociados

**Servicios / Tarifas:**
- Listado de servicios por especialidad con tarifa formateada
- Registro de servicio asociado a una especialidad (nombre y tarifa en USD)
- Validacion: tarifa debe ser un valor numerico mayor a cero
- Edicion del nombre o la tarifa de un servicio
- Eliminacion de un servicio sin afectar la especialidad

**Rutas implementadas:** `especialidades/listar`, `especialidades/crear`, `especialidades/guardar`, `especialidades/editar`, `especialidades/actualizar`, `especialidades/eliminar`, `servicios/listar`, `servicios/crear`, `servicios/guardar`, `servicios/editar`, `servicios/actualizar`, `servicios/eliminar`

### Integrante 4 — Citas y Pagos (CRUD completo)

**Citas:**
- Listado completo de citas con paciente, medico, especialidad, fecha, hora, estado y motivo
- Creacion de cita con seleccion de paciente y medico, validacion de fecha futura
- Validacion de cruce de horario: no permite agendar dos citas al mismo medico en la misma fecha y hora
- Edicion de cita con cambio de estado (pendiente, confirmada, cancelada, atendida)
- Cancelacion mediante borrado logico (cambia estado a `cancelada`, preservando el historial)

**Pagos:**
- Listado de pagos por cita con monto formateado y metodo de pago
- Registro de pago asociado a una cita existente
- Validacion: monto debe ser numerico mayor a cero
- Edicion del monto, metodo de pago (efectivo, tarjeta, transferencia) o fecha
- Eliminacion de un pago registrado por error

**Rutas implementadas:** `citas/listar`, `citas/crear`, `citas/guardar`, `citas/editar`, `citas/actualizar`, `citas/eliminar`, `pagos/listar`, `pagos/crear`, `pagos/guardar`, `pagos/editar`, `pagos/actualizar`, `pagos/eliminar`

## Despliegue en Render

## 📄 Licencia

Proyecto academico — Segundo Parcial de Desarrollo de Aplicacion Web con PHP y MySQL.
