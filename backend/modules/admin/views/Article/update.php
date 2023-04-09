<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Article $model */

$this->title = 'Update Article: ' . $model->articleId;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->articleId, 'url' => ['view', 'articleId' => $model->articleId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
