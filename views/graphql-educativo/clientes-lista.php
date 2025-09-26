<?php
use yii\helpers\Html;
$this->title = 'Listado de Clientes';
?>
<h1><?= Html::encode($this->title) ?></h1>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código Cliente</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Documento</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= Html::encode($c['_id']) ?></td>
            <td><?= Html::encode($c['codigoCliente']) ?></td>
            <td><?= Html::encode($c['nombres']) ?></td>
            <td><?= Html::encode($c['apellidos']) ?></td>
            <td><?= Html::encode($c['email']) ?></td>
            <td><?= Html::encode($c['numeroDocumento']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
