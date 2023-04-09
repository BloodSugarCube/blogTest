<?php

namespace frontend\controllers;

use common\models\Token;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        echo 'Test action';
    }
    public function actionLogin()
    {
    }
    public function actionSignUp()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $newUser = new User();
        $newUser->email = Yii::$app->request->post("email");
        $newUser->username = Yii::$app->request->post("username");
        $newUser->password = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->request->post("password"));
        if (User::findByEmail($newUser->email)) {
            return 'Пользователь с таким e-mail уже имеется.';
        } else {
            $newUser->save();
            $newToken = new Token();
            $newToken->userId = User::findByEmail($newUser->email)->userId;
            $newToken->accessToken = Yii::$app->security->generateRandomString();
            $newToken->save();
            return $newToken->accessToken;
        }
    }
}