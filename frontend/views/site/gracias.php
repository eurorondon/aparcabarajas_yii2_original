<?php
use yii\helpers\Html;

$this->title = 'Gracias por Contactarnos';
?>

<div class="site-gracias">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Tu mensaje ha sido enviado con éxito. Nos pondremos en contacto contigo pronto.</p>
    <p><?= Html::a('Volver al inicio', ['site/index'], ['class' => 'btn btn-primary']) ?></p>
</div>

<style>
    /* Estilo para centrar el contenido */
    .site-gracias {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Altura completa de la ventana */
        text-align: center;
    }
</style>
