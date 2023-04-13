<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(User::userList(), 'userId','username'),
        'options' => [
            'userId' => 'userId',
            'placeholder' => 'Выберите пользователя...'
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ]
    ]);?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
