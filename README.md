<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Integración Yii2 con APIs Externas</h1>
    <h3 align="center">Caso de uso: Sectores Educativos (ISIPASS)</h3>
    <br>
</p>

📦 EXTENSIONES REQUERIDAS
-------------------------

Este proyecto incluye ejemplos de integración con **APIs externas en sectores educativos (ISIPASS)**.  
Para ello, se utilizan las siguientes extensiones/librerías:

- **Composer**  
  Gestor de dependencias en PHP. Facilita la instalación y actualización de librerías externas.  

- **GuzzleHTTP** *(opcional)*  
  Cliente HTTP para PHP. Útil para realizar peticiones a APIs externas como ISIPASS.  
  👉 No forma parte de Yii, pero se integra sin problemas.  

- **cURL (PHP extension)**  
  Extensión nativa de PHP para realizar peticiones HTTP. Se puede usar como alternativa a Guzzle sin necesidad de dependencias adicionales.  

- **vlucas/phpdotenv**  
  Librería para manejar variables de entorno desde un archivo `.env`.  
  Instalación:
  ```bash
  composer require vlucas/phpdotenv

⚙️ MODIFICACIONES NECESARIAS
1. Configurar el index.php de la carpeta web

Después de la variable $config, agregar:

// Cargar dotenv
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


📖 Explicación:
Con esto se cargan automáticamente las variables definidas en el archivo .env ubicado en la raíz del proyecto.
De esta manera puedes acceder a valores sensibles (como TOKEN_ISIPASS) usando:

$token = getenv('TOKEN_ISIPASS');

2. En config/web.php → agregar GraphQL en components
// AQUI REGISTRAMOS NUESTRO SERVICIO GRAPHQL
'graphql' => [
    'class' => 'app\components\GraphqlService',
],


📖 Explicación:
Esto registra un nuevo componente en Yii2 llamado graphql.

