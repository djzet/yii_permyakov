<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Регистрация';

?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form-registration">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
