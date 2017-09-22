<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Solicitud',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="solicitud-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="solicitud-form">
    	<?php echo Html::img('@web/images/' . $model["foto"]); ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        	
        	<input type="file" name="img">

	        <input type="submit" name="img">

        <?php ActiveForm::end(); ?>

    </div>


</div>
