<?php
namespace app\models;

use yii\base\Model;

class FacturaForm extends Model
{
    public $codigoCliente;
    public $email;
    public $actividadEconomica;
    public $codigoMetodoPago;
    public $descuentoAdicional;
    public $nombreEstudiante;
    public $periodoFacturado;
    public $detalle; // JSON de productos

    public function rules()
    {
        return [
            [['codigoCliente','email','actividadEconomica','codigoMetodoPago','nombreEstudiante','periodoFacturado'], 'required'],
            [['descuentoAdicional'], 'number'],
            [['detalle'], 'string'],
            [['email'], 'email'],
        ];
    }
}
