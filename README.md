## Estructura Del Proyecto 🏢
  ~~~bash  
  my-laravel-project/
│── app/                         # Contiene el núcleo de la aplicación
│   ├── Http/                    # Controladores, middleware y solicitudes HTTP
│   │   ├── Controllers/         # Controladores de la aplicación
│   │   │   ├── RegisterController.php  # Controlador para el registro de usuarios
│   │   ├── Middleware/          # Middleware para filtrar solicitudes
│   │   ├── Requests/            # Validaciones de solicitudes HTTP
│   │       ├── RegisterRequest.php  # Validación para el registro de usuarios
│   ├── Models/                  # Modelos Eloquent que representan las tablas de la base de datos
│   │   ├── User.php             # Modelo para la tabla `users`
│   ├── Policies/                # Políticas de autorización
│   │   ├── CategoriesPolicy.php # Reglas de acceso para las categorías
│   ├── Services/                # Lógica de negocio de la aplicación
│       ├── ProductsService.php  # Lógica relacionada con productos
│       ├── CategoriesService.php # Lógica relacionada con categorías
│
│── bootstrap/                   # Inicialización del framework
│   ├── app.php                  # Archivo principal de inicialización
│   ├── cache/                   # Archivos de caché generados por Laravel
│
│── config/                      # Configuración de la aplicación
│   ├── auth.php                 # Configuración de autenticación
│   ├── database.php             # Configuración de la base de datos
│   ├── jwt.php                  # Configuración del paquete JWT
│
│── database/                    # Migraciones, seeders y factories para la base de datos
│   ├── migrations/              # Define la estructura de las tablas
│   ├── seeders/                 # Datos iniciales para poblar la base de datos
│   ├── factories/               # Generación de datos de prueba
│
│── public/                      # Archivos públicos accesibles desde el navegador
│   ├── index.php                # Punto de entrada de la aplicación
│
│── resources/                   # Recursos de la aplicación
│   ├── views/                   # Vistas Blade de la aplicación
│   ├── lang/                    # Archivos de localización para diferentes idiomas
│
│── routes/                      # Define las rutas de la aplicación
│   ├── web.php                  # Rutas para la interfaz web
│   ├── api.php                  # Rutas para la API
│
│── storage/                     # Archivos generados por la aplicación
│   ├── logs/                    # Archivos de registro de errores y eventos
│   ├── framework/               # Archivos de caché y sesiones
│   ├── app/                     # Archivos subidos por los usuarios
│
│── tests/                       # Pruebas automatizadas de la aplicación
│   ├── Feature/                 # Pruebas de características específicas
│   ├── Unit/                    # Pruebas unitarias
│
│── vendor/                      # Dependencias instaladas por Composer
│
│── artisan                      # CLI de Laravel para ejecutar comandos
│── composer.json                # Dependencias del proyecto y configuración de Composer
│── .env                         # Variables de entorno (configuración sensible)
│── README.md                    # Explicación del proyecto
  ~~~
  
  ## Arquitectura y Código 👷‍♂️
  - MVC (Model-View-Controller):
    - Laravel ya implementa este patrón, separando las responsabilidades entre Modelos, Vistas y Controladores.
    - Justificación: Facilita el mantenimiento y escalabilidad al dividir la lógica de negocio, la presentación y el acceso a datos.

  - Service Layer :
    - Justificación: Centraliza la lógica de negocio en una capa independi
    ente, lo que permite reutilizarla y probarla fácilmente.

  - Repository Pattern: 
    - Justificación: Abstrae el acceso a los datos, lo que facilita cambiar la fuente de datos (por ejemplo, de una base de datos a una API externa) sin afectar otras capas.
  
  ## Beneficios de esta Arquitectura 🧑‍💻
  - Mantenibilidad: Cada capa tiene responsabilidades claras, lo que facilita el mantenimiento.
  - Escalabilidad: Puedes agregar nuevas funcionalidades sin afectar otras capas.
  - Pruebas: Es más fácil probar cada capa de forma aislada.

 ## Requerimientos
  Para ejecutar esta API, es necesario tener Docker instalado en el equipo
  ~~~bash  
   https://www.docker.com/
  ~~~

 ## Configurar variable mysql
 Configura las variables de MySQL. Si necesitas modificar container_name, MYSQL_DATABASE o MYSQL_ROOT_PASSWORD a tu gusto, puedes hacerlo desde el archivo  [docker-compose](https://github.com/Rrosso27/Prueba_T-cnica_Desarrollador_PHP_Backend/blob/main/docker-compose.yml), específicamente en esta sección: 
   ~~~bash  
     mysql:
    image: mysql:8.0
    container_name: laravel_db
    restart: always
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - laravel
  ~~~
  No es necesario realizar cambios en el docker-compose, ya que la configuración predeterminada debería funcionar correctamente. La personalización es completamente opcional



 ## .env 
  - en la raíz del proyecto te encontrarás  una archivo con el nombre de   [.env.example](https://github.com/Rrosso27/Prueba_T-cnica_Desarrollador_PHP_Backend/blob/main/.env.example)  crea una copi y renombrarla como .env 
  - Si realizaste cambios en las variables de MySQL, recuerda actualizar db_port con el puerto que hayas decidido utilizar, así como db_database, db_username y db_password según tu configuración personalizada. Sin embargo, estos cambios no son necesarios si no modificaste nada en el archivo [docker-compose](https://github.com/Rrosso27/Prueba_T-cnica_Desarrollador_PHP_Backend/blob/main/docker-compose.yml)
  ~~~bash  
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=secret
  ~~~
  ## Construir y levantar los contenedores 🚀  
  Ejecuta los siguientes comandos en la terminal desde la raíz de tu proyecto:
  ~~~bash  
   docker-compose up -d --build
  ~~~
 ## Generar la clave secreta JWT
 Esto agregará JWT_SECRET al archivo .env:
  ~~~bash  
  php artisan jwt:secret
  ~~~

  ## Verificar la aplicación 🔥  
  - Accede a tu aplicación en http://localhost:8080
  - Si necesitas ejecutar comandos de Artisan, puedes hacerlo dentro del contenedor
  ~~~bash  
    docker exec -it laravel_app  
  ~~~

  ### Generan las migraciones 
  Mediante las migraciones se crearán todas las tablas necesarias para el correcto funcionamiento de la API.
  ~~~bash  
    docker exec -it laravel_app php artisan migrate
  ~~~

  ## Seeders 
  Ejecuta el seeder para generar un usuario de prueba con el rol de administrador, en caso de que lo necesites
  ~~~bash  
     docker exec -it laravel_app php artisan db:seed
  ~~~
  Esto generará un usuario administrador con el correo electrónico admin@gmail.com y la contraseña 12345678
  - email
  ~~~bash  
     admin@gmail.com
  ~~~
  - contraseña
  ~~~bash  
     12345678
  ~~~


