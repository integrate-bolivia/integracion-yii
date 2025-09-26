<?php
$this->title = 'Gestión de Facturas';
use yii\helpers\Html;
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>CUF</th>
            <th>Estado</th>
            <th>Número Factura</th>
            <th>Fecha Emisión</th>
            <th>Punto de Venta</th>
            <th>Cliente</th>
            <th>PDF</th>
            <th>XML</th>
            <th>Rollo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($facturas as $f): ?>
            <tr>
                <td><?= Html::encode($f['cuf']) ?></td>
                <td><?= Html::encode($f['state']) ?></td>
                <td><?= Html::encode($f['numeroFactura']) ?></td>
                <td><?= Html::encode($f['fechaEmision']) ?></td>
                <td><?= Html::encode($f['puntoVenta']['codigo'] ?? '') ?></td>
                <td><?= Html::encode($f['cliente']['razonSocial'] ?? '') ?></td>
                <td><a href="<?= $f['representacionGrafica']['pdf'] ?? '#' ?>" target="_blank">PDF</a></td>
                <td><a href="<?= $f['representacionGrafica']['xml'] ?? '#' ?>" target="_blank">XML</a></td>
                <td><a href="<?= $f['representacionGrafica']['rollo'] ?? '#' ?>" target="_blank">Rollo</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
