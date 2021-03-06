<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/change-email', 'token' => $user->reset_token]);
?>
<div class="password-reset">
    <p>Hello,</p>

    <p>Follow the link below to change your email:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
