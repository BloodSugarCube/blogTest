<?php

namespace frontend\controllers;

use common\models\CreateArticleForm;
use common\models\GetArticlesForm;
use Yii;
use yii\web\Controller;

class ArticleController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new CreateArticleForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->createArticle()) {
            return $model->getArticle();
        } else {
            $errors = $model->getErrors();
            return $errors;
        }
    }

    public function actionArticles()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new GetArticlesForm();
        $model->load(\Yii::$app->request->get(), '');
        if ($model->getByLimitOffsetId()) {
            return $model->getArticles();
        } else {
            $errors = $model->getErrors();
            return $errors;
        }
    }
}
