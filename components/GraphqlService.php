<?php

namespace app\components;

use GuzzleHttp\Client;
use Yii;

/**
 * GraphqlService
 *
 * Servicio central para conectarse a un endpoint GraphQL.
 * Se basa en GuzzleHttp para realizar las peticiones y devuelve
 * la sección "data" de la respuesta en formato array asociativo.
 *
 * Flujo de uso típico:
 * 1. Construir la query/mutation GraphQL (ej: LOGIN, listar productos, etc).
 * 2. Llamar a `request($query, $variables, $token)`
 * 3. Manejar la respuesta (data) o el error (exception).
 */
class GraphqlService
{
    /** @var Client Cliente HTTP que ejecuta las peticiones */
    private $client;

    /** @var string URL del endpoint GraphQL */
    private $endpoint;

    /**
     * Constructor
     *
     * Inicializa la conexión con el endpoint GraphQL.
     * - base_uri → dirección del servidor (ejemplo: sandbox de ISIPASS)
     * - timeout → tiempo máximo de espera por la respuesta (segundos)
     */
    public function __construct()
    {
        $this->endpoint = "https://sandbox.isipass.net/sectorEducativo"; // Cambiar a demo/prod si es necesario
        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 10.0,
        ]);
    }

    /**
     * request
     *
     * Ejecuta cualquier query o mutation GraphQL contra el endpoint.
     *
     * @param string $query     Consulta/mutación GraphQL en formato string (heredoc recomendado).
     * @param array  $variables Variables asociadas a la query (opcionales).
     * @param string $token     Token de autenticación Bearer (opcional).
     *
     * @return array|null Devuelve la sección "data" de la respuesta o null si no existe.
     *
     * @throws \Exception Si GraphQL devuelve errores (se registran en el log de Yii).
     *
     * Ejemplo de uso:
     * ```php
     * $query = <<<GQL
     * mutation LOGIN($shop: String!, $email: String!, $password: String!) {
     *   login(shop: $shop, email: $email, password: $password) {
     *     token
     *     refreshToken
     *   }
     * }
     * GQL;
     *
     * $result = $graphql->request($query, [
     *   'shop' => 'mi_tienda',
     *   'email' => 'usuario@test.com',
     *   'password' => '123456',
     * ]);
     *
     * $token = $result['login']['token'];
     * ```
     */
    public function request($query, $variables = [], $token = null)
    {
        // Si no recibimos token, usamos el de .env
        $token = $token ?? getenv('TOKEN_ISIPASS');
        // Cabeceras básicas de la petición (JSON)
        $headers = ['Content-Type' => 'application/json'];

        // Si se pasa un token, se agrega como Authorization: Bearer {token}
        if ($token) {
            $headers['Authorization'] = "Bearer " . $token;
        }

        // Se envía la petición POST con el cuerpo JSON (query + variables)
        $response = $this->client->post('', [
            'headers' => $headers,
            'json'    => [
                'query'     => $query,
                'variables' => (object) $variables, // cast a objeto para GraphQL
            ],
        ]);

        // Se convierte la respuesta JSON en array asociativo PHP
        $body = json_decode($response->getBody(), true);

        // Si GraphQL responde con errores, se registran y se lanza excepción
        if (isset($body['errors'])) {
            Yii::error($body['errors'], __METHOD__);
            throw new \Exception("GraphQL error: " . json_encode($body['errors']));
        }

        // Devuelve solo la parte "data"
        return $body['data'] ?? null;
    }
}
