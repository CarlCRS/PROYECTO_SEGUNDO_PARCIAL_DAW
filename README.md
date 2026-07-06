# Sistema de Citas Medicas

Aplicacion web para la gestion de citas medicas entre pacientes y medicos,
desarrollada en PHP + MySQL siguiendo el patron MVC.

## Tecnologias

- PHP 8.x
- MySQL / MariaDB
- HTML5, CSS3, JavaScript
- PDO (PHP Data Objects)
- Git + GitHub
- Render (despliegue)

## Estructura del proyecto

```
/
├── public/           # Front controller y archivos publicos
│   ├── index.php     # Punto de entrada (Front Controller)
│   ├── css/          # Hojas de estilo
│   └── js/           # Scripts JavaScript
├── app/
│   ├── controllers/  # Controladores (logica de negocio)
│   ├── models/       # Modelos (acceso a datos)
│   └── views/        # Vistas (interfaz de usuario)
├── config/           # Configuracion de la base de datos
├── database/         # Script SQL de la base de datos
├── .env.example      # Variables de entorno de ejemplo
├── .gitignore
└── README.md
```

## Instalacion local

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/CarlCRS/PROYECTO_SEGUNDO_PARCIAL_DAW.git
   cd PROYECTO_SEGUNDO_PARCIAL_DAW
   ```

2. Crear la base de datos ejecutando `database/database.sql` en MySQL.

3. Copiar `.env.example` a `.env` y configurar las credenciales:

   ```
   DB_HOST=localhost
   DB_NAME=citas_medicas
   DB_USER=root
   DB_PASS=
   ```

4. Iniciar el servidor de desarrollo:

   ```bash
   php -S localhost:8000 -t public
   ```

5. Abrir en el navegador: http://localhost:8000

## Usuario de prueba

- **Correo:** admin@clinica.com
- **Contraseña:** admin123

## Estado del proyecto

| Modulo               | Estado        | Integrante |
| -------------------- | ------------- | ---------- |
| Pacientes            | ✅ Completo   | 1          |
| Antecedentes medicos | ✅ Completo   | 1          |
| Medicos              | ✅ Completo   | 2          |
| Horarios             | ✅ Completo   | 2          |
| Especialidades       | ✅ Completo   | 3          |
| Servicios / Tarifas  | ✅ Completo   | 3          |
| Citas                | ⬜ Pendiente  | 4          |
| Pagos                | ⬜ Pendiente  | 4          |
| Autenticacion        | ⬜ Pendiente  | Equipo     |

## Modulos del sistema

| Integrante | Entidad 1      | Entidad 2                  | Relacion                     |
| ---------- | -------------- | -------------------------- | ---------------------------- |
| 1          | Pacientes      | Antecedentes medicos       | 1 paciente → N antecedentes  |
| 2          | Medicos        | Horarios de disponibilidad | 1 medico → N horarios        |
| 3          | Especialidades | Servicios / Tarifas        | 1 especialidad → N servicios |
| 4          | Citas          | Pagos                      | 1 cita → 1 o mas pagos       |

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

## Despliegue en Render

1. Crear una base de datos MySQL en Railway o Clever Cloud.
2. Conectar el repositorio de GitHub a Render como Web Service.
3. Configurar las variables de entorno en Render:
   - `DB_HOST`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
4. Render servira automaticamente la carpeta `/public` como raiz.

## Demo en linea
