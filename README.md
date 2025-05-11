  ## Arquitectura y Código
  - MVC (Model-View-Controller):
    - Laravel ya implementa este patrón, separando las responsabilidades entre Modelos, Vistas y Controladores.
    - Justificación: Facilita el mantenimiento y escalabilidad al dividir la lógica de negocio, la presentación y el acceso a datos.

  - Service Layer :
    - Justificación: Centraliza la lógica de negocio en una capa independi
    ente, lo que permite reutilizarla y probarla fácilmente.

  - Repository Pattern: 
    - Justificación: Abstrae el acceso a los datos, lo que facilita cambiar la fuente de datos (por ejemplo, de una base de datos a una API externa) sin afectar otras capas.
  
  ## Beneficios de esta Arquitectura
  - Mantenibilidad: Cada capa tiene responsabilidades claras, lo que facilita el mantenimiento.
  - Escalabilidad: Puedes agregar nuevas funcionalidades sin afectar otras capas.
  - Pruebas: Es más fácil probar cada capa de forma aislada.

  ## Construir y levantar los contenedores 🚀  
  Ejecuta los siguientes comandos en la terminal desde la raíz de tu proyecto:
  ~~~bash  
   docker-compose up -d --build
  ~~~
 
  ## Verificar la aplicación 🔥  
  - Accede a tu aplicación en http://localhost:8080
  - Si necesitas ejecutar comandos de Artisan, puedes hacerlo dentro del contenedor
  ~~~bash  
    docker exec -it laravel_app php artisan migrate
  ~~~
