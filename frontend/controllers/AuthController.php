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
        $user = User::findByEmail(Yii::$app->request->post("email"));
        $password = Yii::$app->request->post("password");

        if ($user != NULL && Yii::$app->security->validatePassword($password, $user->password)) {
            $tokenQuery = Token::findOne(['userId' => $user->userId]);
            $accessToken = $tokenQuery->accessToken;
            return  $accessToken;
        } else {
            return 'Email или password введён неправильно.';
        }
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