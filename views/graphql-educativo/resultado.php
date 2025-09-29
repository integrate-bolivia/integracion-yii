<?php

use yii\helpers\Html;

$this->title = 'Resultado GraphQL';
?>

<h1><?= Html::encode($this->title) ?></h1>

<pre><?= print_r($data, true) ?></pre>
<p><?= Html::a('Volver', ['registrar-factura'], ['class' => 'btn btn-primary']) ?></p>