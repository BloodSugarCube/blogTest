<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Article;

/** @var yii\web\View $this */
/** @var common\models\Article $model */

$this->title = 'Article №'.$model->articleId;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'articleId' => $model->articleId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'articleId' => $model->articleId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'articleId',
            [
                'attribute' => 'User',
                'format' => 'html',
                'value' => function (Article $model) {
                    return (!empty($model->user)) ? Html::a($model->user->username, ['user/view', 'userId' => $model->userId]) : null;
                },
            ],
            'text:ntext',
        ],
    ]) ?>

</div>
