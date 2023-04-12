<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Token;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ArticleController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $accessToken = Yii::$app->request->post("accessToken");
        $text = Yii::$app->request->post("text");

        $token = Token::find()
            ->where(['accessToken' => $accessToken])
            ->one();

        if (empty($token)) {
            return 'Необходимо указать accessToken';
        }
        if (empty($text)) {
            return 'Необходимо указать text';
        }

        $article = new Article;
        $article->userId = $token->userId;
        $article->text = $text;

        if (!$article->save()) {
            return 'Не удалось сохранить статью' . var_export($article->getErrors(), true);
        };

        $article->serializeToArray();

        return [
            "articles" => $article,
        ];
    }

    public function actionGetArticles()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $limit = Yii::$app->request->get("limit", 10);
        $offset = Yii::$app->request->get("offset", 0);

        $articleQuery = Article::find()
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['articleId' => SORT_DESC]);

        $result = [];
        foreach ($articleQuery->each() as $article) {
            $result[] = $article->serializeToArray();
        }

        return [
            "articles" => $result,
        ];
    }

    public function actionGetUserArticles()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $limit = Yii::$app->request->get("limit", 10);
        $offset = Yii::$app->request->get("offset", 0);
        $userId = Yii::$app->request->get("userId", 0);

        $articleQuery = Article::find()
            ->limit($limit)
            ->offset($offset)
            ->andWhere(['userid' => $userId])
            ->orderBy(['articleId' => SORT_DESC]);

        $result = [];
        foreach ($articleQuery->each() as $article) {
            $result[] = $article->serializeToArray();
        }

        return [
            "userArticles" => $result,
        ];
    }
}
