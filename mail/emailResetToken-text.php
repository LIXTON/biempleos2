<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/change-email', 'token' => $user->reset_token]);
?>
Hello,

Follow the link below to change your email:

<?= $resetLink ?>
