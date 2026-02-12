# 🎬 Nostromo

**Nostromo** es una aplicación web para la gestión y compra de entradas de cines independientes. Los usuarios pueden consultar la cartelera, registrarse, iniciar sesión, seleccionar funciones, realizar reservas y gestionar su perfil. Además, el sistema incluye un panel de administración para gestionar cines, salas y proyecciones.

---

## 🚀 Acceso al proyecto

La aplicación está desplegada en Render y disponible en el siguiente enlace:

🔗 [Acceder a Nostromo](https://nostromo-app.onrender.com/) 

---

## 🛠️ Tecnologías utilizadas

- **Frontend**:
  - HTML
  - CSS
  - JavaScript (`fetch` para comunicación con la API)

- **Backend**:
  - PHP (API RESTful)
  - Slim Framework
  - PostgreSQL (base de datos relacional)
  - Apache (servidor web, ejecutado en contenedor Docker)

- **Herramientas de desarrollo**:
  - Render (hosting y base de datos)
  - DBeaver (gestión de la base de datos)
  - Amazon Web Services (AWS): almacenamiento de archivos multimedia a través de URLs públicas

  - Firebase JWT (autenticación con tokens)

---

## 🗂️ Estructura del proyecto

- `app/`  
  Contiene todos los recursos del lado del cliente (frontend).
  - `css/`: hojas de estilo para la interfaz.
  - `includes/`: fragmentos PHP reutilizables como encabezados, pie de página, validaciones, etc.
  - `js/`: scripts JavaScript que gestionan la lógica del cliente y las llamadas a la API con `fetch`.
  - `servicios/`: intermediarios o módulos que comunican vistas con el backend.
  - `src/`: recursos adicionales usados en el frontend.
  - `vistas/`: vistas principales de la aplicación (inicio, login, registro, selección de sesión, perfil, etc.).

- `Diseño/`  
  Carpeta que contiene recursos visuales y documentación gráfica del diseño de la aplicación en Figma.

- `servicios_rest/`  
  Contiene el backend y la API desarrollada en PHP.
  - `Firebase/`: librerías necesarias para la generación y validación de JSON Web Tokens (JWT).
  - `Slim/`: archivos y dependencias del framework Slim, utilizado para el enrutamiento de la API.
  - `src/`: código fuente principal del backend, incluyendo `index.php` como punto de entrada y `funciones.php` con toda la lógica de conexión y consulta a la base de datos.

---

## 🌐 Acceso a Render

Todo el proyecto **Nostromo**, incluyendo la aplicación web (API y vistas) y la base de datos **PostgreSQL**, está desplegado en la plataforma en la nube **Render**.

Se puede acceder al panel de control de Render con las siguientes credenciales:

- **Sitio web**: [Dashboard](https://dashboard.render.com/)
- **Correo de acceso**: `menaflores.victor@gmail.com`
- **Contraseña**: `Fhloston_Multipase25`

Desde el panel de Render se puede acceder a los siguientes servicios del proyecto:

- **nostromo-app**: Contiene toda la parte del cliente, incluyendo las vistas HTML, los estilos CSS y los scripts JavaScript.
- **nostromo-api**: Servicio que gestiona el backend del proyecto. Aquí se encuentra la API desarrollada en PHP que se comunica con la base de datos.
- **nostromo-db**: Instancia de la base de datos PostgreSQL donde se almacena toda la información de la aplicación, como usuarios, cines, salas, funciones y reservas.



---

## ☁️ Almacenamiento de medios

Todos los archivos multimedia del proyecto (como carteles de películas, imágenes promocionales y recursos gráficos) están alojados en **Amazon Web Services (AWS)**, utilizando su servicio de almacenamiento en la nube para garantizar un acceso rápido y estable desde la aplicación.

Los recursos multimedia se cargan dinámicamente desde las URLs públicas de AWS.

- 🎞️ [Carteles de películas (cartelera y proximamente)](https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/)
- 📰 [Imágenes para artículos en Bitácora Nostromo](https://nostromo-media.s3.eu-north-1.amazonaws.com/articulos/)

Se puede acceder a **AWS** con las siguientes credenciales:

- **Sitio web**: [AWS-S3](https://eu-north-1.console.aws.amazon.com/s3/home?region=eu-north-1)
- **Correo de acceso**: `vmenflo707@g.educaand.es`
- **Contraseña**: `Fhloston_Multipase25`


---

## 🔄 Funcionamiento general

He creado dos usuarios en la base de datos para que podais realiar el proceso de compra de una entrada (requiere iniciar sesión o crear una cuenta), y otro usuario administrador para que podais entrar en el panel de control de gestión de Nostromo.

Usuario Normal
- **Correo de acceso**: `victor@correo.com`
- **Contraseña**: `123`

Una vez que el usuario ha iniciado sesión o se ha registrado, puede simular una compra siguiendo los siguientes criterios:

### ✅ **Compra exitosa**
Para que la compra se complete correctamente:

- **Número de tarjeta**: cualquier combinación de dígitos **que termine en 1**
- **Fecha de caducidad**: una **fecha válida y posterior a la actual**
- **CVC**: opcional (puede dejarse vacío o introducir cualquier valor)

### ❌ **Compra fallida**
La compra será rechazada si se cumplen cualquiera de las siguientes condiciones:

- **Número de tarjeta**: termina en **0**
- **Fecha de caducidad**: **inválida** o **anterior a la fecha actual**
- **CVC**: opcional

> ℹ️ Estas validaciones son simuladas y se realizan únicamente del lado del cliente como parte del proceso de prueba.

Usuario Admin
- **Correo de acceso**: `admin@correo.com`
- **Contraseña**: `123`

1. El usuario accede a las vistas PHP que componen la interfaz de usuario.
2. JavaScript (mediante `fetch`) realiza peticiones a la API desarrollada en PHP.
3. La API procesa las solicitudes, accede a la base de datos PostgreSQL y devuelve las respuestas en formato JSON.
4. Los datos se muestran dinámicamente en el navegador, mejorando la experiencia del usuario al evitar recargas completas de página.
5. El backend también se encarga de gestionar sesiones, autenticación mediante JWT y control de acceso según el tipo de usuario (normal o administrador).

---

## 📁 Repositorio

Todo el código fuente del proyecto está disponible en el siguiente repositorio:

🔗 [Proyecto-Nostromo](https://github.com/vmenflo/Proyecto-Nostromo)


---

## ✍️ Autor

- **Víctor Mena Flores**
- Proyecto final integrado para el Grado Superior Desarrollo de Aplicaciones Web. I.E.S Mar de Alborán
