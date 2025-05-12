

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
  ## Construir y levantar los contenedores (local y aws) 🚀  
  Ejecuta los siguientes comandos en la terminal desde la raíz de tu proyecto:
  ~~~bash  
   docker-compose up -d --build
  ~~~
 ## Generar la clave secreta JWT
 Esto agregará JWT_SECRET al archivo .env:
  ~~~bash  
    docker exec -it laravel_app php artisan jwt:secret
  ~~~

  ## Verificar la aplicación 🔥  
  - Accede a tu aplicación en local http://localhost:8080 , en caso de realizar el despliegue en la nube, asegúrese de realizar la prueba por su url o ip pública y el puerto 8000 
  - Si necesitas ejecutar comandos de Artisan, puedes hacerlo dentro del contenedor
  ~~~bash  
    docker exec -it laravel_app  
  ~~~

  ## Configuración de AWS (esta sección es exclusiva para el despliegue en AWS; si estás trabajando en local, puedes omitirla)
  - PASOS PARA ASIGNAR UNA ELASTIC IP EN AWS (EC2)
    - (1) Ve al panel de EC2:
      - Entra a https://console.aws.amazon.com/ec2/
      - Asegúrate de estar en la región correcta (ejemplo: us-east-1).
    -  (2) Solicita una Elastic IP:
      - En el menú lateral izquierdo, haz clic en "Elastic IPs" (bajo "Network & Security").
      - Clic en "Allocate Elastic IP address".
      -Deja las opciones por defecto y haz clic en "Allocate".
    - (3) Asocia la Elastic IP a tu instancia EC2
      - Selecciona la IP recién creada.
      - Clic en "Actions" → "Associate Elastic IP address".
      -En el formulario:
        - En “Instance”, selecciona tu instancia EC2.
        - En “Private IP address”, déjalo en automático (usualmente aparece uno solo).
      - Clic en "Associate".
    - (4) Verifica que Laravel esté sirviendo en 0.0.0.0

      - Si usas el servidor de desarrollo (php artisan serve), debes arrancarlo así dentro del contenedor:
         ~~~bash  
          sudo docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000
          ~~~
       - Ahora puedes ver que tu instancia EC2 tiene una IP pública estática.
       - Puedes acceder con:
         ~~~bash  
            http://<tu-elastic-ip>:8000
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

## Colección Postman
 - Importar la colección [smart.postman_collection](https://github.com/Rrosso27/Prueba_T-cnica_Desarrollador_PHP_Backend/blob/main/smart.postman_collection)  en Postman
 Abre Postman: 

   -  Haz clic en “Import” (botón arriba a la izquierda).

   -  Selecciona la pestaña “File”.

   -  Arrastra el archivo .json o haz clic en “Upload Files” para buscarlo.

   -  Postman importará la colección y la verás en la barra lateral izquierda.
 - Usar la colección:
    - En el panel izquierdo (sidebar), verás la colección bajo “Collections”.

    - Ábrela y selecciona cualquier endpoint.
    - Asegúrate de configurar correctamente:
      - El entorno (Environment) si tiene variables como {{base_url}}.
      - Las cabeceras (Headers) y cuerpo (Body) si son necesarias.

  -  Configurar variables (opcional pero recomendado). Si la colección usa variables como {{base_url}}
     - Ve a la esquina superior derecha y haz clic en “Environments” → “Manage Environments”.
     - Crea uno nuevo (ej: "Local Laravel").
     - Agrega variables como:
        - base_url: http://localhost:8000 o la IP pública de tu EC2 (ej: http://18.xxx.xxx.xxx)
     - Guarda y selecciona ese entorno antes de hacer peticiones. 

## URL pública de despliegue.
Esta ruta ya dispone de un usuario administrador preconfigurado
  ~~~bash  
    http://18.116.51.144:8000/api
  ~~~
usuario: 
  ~~~bash  
     admin@gmail.com
  ~~~
contraseña: 
  ~~~bash  
     12345678
  ~~~

## Decisiones de diseño:
 - Elección de enum vs tabla de roles.
    - Más simple y rápido
    - No necesitas crear y mantener una tabla para almacenar valores fijos.
 - Middleware o paquete de autorización.
   -  middleware('auth:api')
   -  laravel policies
 - Cambio al esquema de BD o endpoints originales.
    - Se agregó el campo rol en la tabla de usuarios.
    - Se eliminó el campo email_verified_at porque en este caso no es necesario.
    


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


