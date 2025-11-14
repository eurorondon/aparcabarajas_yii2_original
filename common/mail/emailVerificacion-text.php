<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);

?>

Bienvenidos a Parking Plus,

Estimado Cliente hemos recibido una reservacion a través de nuestro sistema en linea.

    Si desea verificar sus reservas u otros productos asociados a la misma puede iniciar sesión en nuestro sistema con los siquientes datos:

    Usuario : <?= $user->username ?>
    Contraseña : N° de Documento de Identidad.

    Para cualquier duda o sugerencia no dude en contactarnos

    Reservaciones: reservas@aparcabarajas.es
    +34 613 91 05 71
