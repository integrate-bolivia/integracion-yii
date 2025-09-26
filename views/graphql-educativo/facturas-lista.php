<?php
use yii\helpers\Html;

$this->title = 'Listado de Facturas';
?>
<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>CUF</th>
            <th>Número Factura</th>
            <th>Fecha Emisión</th>
            <th>Cliente</th>
            <th>Punto de Venta</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($facturas as $f): ?>
            <tr>
                <td><?= Html::encode($f['cuf']) ?></td>
                <td><?= Html::encode($f['numeroFactura']) ?></td>
                <td><?= Html::encode($f['fechaEmision']) ?></td>
                <td><?= Html::encode($f['cliente']['razonSocial'] ?? '') ?></td>
                <td><?= Html::encode($f['puntoVenta']['codigo'] ?? '') ?></td>
                <td><?= Html::encode($f['state']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
