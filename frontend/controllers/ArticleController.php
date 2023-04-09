<?php

namespace frontend\controllers;

use common\models\Article;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ArticleController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        echo 'Test action';
    }
    public function actionCreate()
    {
        // $model = new Article();
    }
    public function actionGetArticles()
    {
        $limit = Yii::$app->request->get("limit");
        $offset = Yii::$app->request->get("offset");
        $articleQuery = Article::find()
            ->limit($limit)
            ->offset($offset);
        $result = [];
        foreach ($articleQuery->each() as $article){
            $result[] = $article->serializeToArray();
        }
        return $result;
    }
    public function actionGetUserAricles()
    {
        // return $result;
    }
}
