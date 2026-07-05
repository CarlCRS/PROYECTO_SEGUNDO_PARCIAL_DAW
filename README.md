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

## Modulos del sistema

| Integrante | Entidad 1      | Entidad 2                  | Relacion                     |
| ---------- | -------------- | -------------------------- | ---------------------------- |
| 1          | Pacientes      | Antecedentes medicos       | 1 paciente → N antecedentes  |
| 2          | Medicos        | Horarios de disponibilidad | 1 medico → N horarios        |
| 3          | Especialidades | Servicios / Tarifas        | 1 especialidad → N servicios |
| 4          | Citas          | Pagos                      | 1 cita → 1 o mas pagos       |

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
