<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\FacturaForm;

class GraphqlEducativoController extends Controller
{
    // Genera un token de autenticación a partir del shop, email y password
    public function actionLogin()
    {
        $query = <<<GRAPHQL
mutation LOGIN(\$shop: String!, \$email: String!, \$password: String!) {
    login(shop: \$shop, email: \$email, password: \$password) {
        token
    }
}
GRAPHQL;
        // Generamos las variables de la mutación
        $variables = [
            'shop' => 'sandbox',
            'email' => 'nickyduran80@gmail.com',
            'password' => '12925818',
        ];

        try {
            $data = Yii::$app->graphql->request($query, $variables);
            Yii::$app->session->set('token', $data['login']['token']);
            return $this->renderContent("<pre>Login OK\nToken: " . $data['login']['token'] . "</pre>");
        } catch (\Exception $e) {
            return $this->renderContent("Error GraphQL: " . $e->getMessage());
        }
    }

    // Lista los productos educativos registrados
    public function actionProductos()
    {
        $query = <<<GRAPHQL
query LISTADO {
    sectorEducativoProductoListado(limit: 100, query: "") {
        pageInfo { totalDocs }
        docs { 
            codigoProducto
            nombre
            descripcion
        } 
    }
}
GRAPHQL;

        try {
            $token = Yii::$app->session->get('token');
            $data = Yii::$app->graphql->request($query, [], $token);
            return $this->renderContent("<pre>" . print_r($data, true) . "</pre>");
        } catch (\Exception $e) {
            return $this->renderContent("Error GraphQL: " . $e->getMessage());
        }
    }

    // Muestra el listado de facturas emitidas
    public function actionFacturasLista()
    {
        $query = <<<GRAPHQL
query LISTADO {
    facturaSectorEducativoListado(reverse: true, limit: 125, query: "") {
        docs {
            cuf
            numeroFactura
            fechaEmision
            cliente { razonSocial }
            puntoVenta { codigo }
            state
        }
    }
}
GRAPHQL;

        try {
            $token = Yii::$app->session->get('token');
            $data = Yii::$app->graphql->request($query, [], $token);
            $facturas = $data['facturaSectorEducativoListado']['docs'] ?? [];

            return $this->render('facturas-lista', [
                'facturas' => $facturas
            ]);
        } catch (\Exception $e) {
            return $this->renderContent("Error GraphQL: " . $e->getMessage());
        }
    }

    // Muestra el listado de clientes
    public function actionClientesLista()
    {
        $query = <<<GRAPHQL
query CLIENTES_LISTADO {
    clientesAll(limit:100, page:1, query:"numeroDocumento!=99001") {
        pageInfo {
            hasNextPage
            hasPrevPage
            totalDocs
            limit
            page
            totalPages
        }
        docs {
            _id
            codigoCliente
            nombres
            apellidos
            email
            numeroDocumento
        }
    }
}
GRAPHQL;

        try {
            $token = Yii::$app->session->get('token');
            $data = Yii::$app->graphql->request($query, [], $token);
            $clientes = $data['clientesAll']['docs'] ?? [];

            return $this->render('clientes-lista', [
                'clientes' => $clientes
            ]);
        } catch (\Exception $e) {
            return $this->renderContent("Error GraphQL: " . $e->getMessage());
        }
    }

    // Muestra formulario + registra una factura nueva
    public function actionRegistrarFactura()
    {
        $model = new FacturaForm();

        // Definir aquí los códigos de punto de venta y sucursal
        $codigoPuntoVenta = 0; // <-- Cambiar al código correspondiente
        $codigoSucursal   = 0; // <-- Cambiar al código correspondiente

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $detalle = json_decode($model->detalle, true);

            // Validar que detalle sea un array no vacío
            if (!is_array($detalle) || empty($detalle)) {
                Yii::$app->session->setFlash('error', 'Debe ingresar al menos un detalle de factura válido.');
                return $this->render('//site/form-registro-factura', ['model' => $model]);
            }

            // Asegurar tipos correctos para GraphQL
            foreach ($detalle as &$item) {
                $item['cantidad'] = (int) $item['cantidad'];
                $item['unidadMedida'] = (int) $item['unidadMedida'];
                $item['precioUnitario'] = (float) $item['precioUnitario'];
                $item['montoDescuento'] = (float) $item['montoDescuento'];
            }
            unset($item);

            $query = <<<GRAPHQL
mutation EDU_REGISTRO_ONLINE(
    \$input: FacturaSectorEducativoInput!,
) {
    facturaSectorEducativoRegistro(
        notificacion: false,
        entidad: {codigoSucursal: $codigoSucursal, codigoPuntoVenta: $codigoPuntoVenta},
        input: \$input
    ) {
        cuf
        state
        numeroFactura
    }
}
GRAPHQL;

            $variables = [
                'input' => [
                    'cliente' => [
                        'codigoCliente' => $model->codigoCliente,
                        'email' => $model->email
                    ],
                    'actividadEconomica' => $model->actividadEconomica,
                    'codigoMetodoPago' => (int) $model->codigoMetodoPago, // asegurar tipo Int
                    'descuentoAdicional' => (float) $model->descuentoAdicional, // asegurar tipo Float
                    'nombreEstudiante' => $model->nombreEstudiante,
                    'periodoFacturado' => $model->periodoFacturado,
                    'detalle' => $detalle
                ],
                'codigoPuntoVenta' => $codigoPuntoVenta,
                'codigoSucursal' => $codigoSucursal,
            ];


            try {
                $token = Yii::$app->session->get('token');
                $data = Yii::$app->graphql->request($query, $variables, $token);
                return $this->render('resultado', ['data' => $data]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('//site/form-registro-factura', ['model' => $model]);
    }
}
