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

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $email = Yii::$app->request->post("email");
        $password = Yii::$app->request->post("password");

        $user = User::findByEmail($email);

        if (empty($user)) {
            return 'E-mail введён неправильно.';
        }
        if (!Yii::$app->security->validatePassword($password, $user->password)) {
            return 'Password введён неправильно.';
        }

        $token = Token::generateNewToken($user->userId);

        if (empty($token)) {
            return 'Не удалось сгенерировать ключ доступа.';
        }

        return [
            "accessToken" => $token->accessToken,
        ];
    }

    public function actionSignUp()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $email = Yii::$app->request->post("email");
        $username = Yii::$app->request->post("username");
        $password = Yii::$app->request->post("password");
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($password);

        $newUser = new User();
        $newUser->email = $email;
        $newUser->username = $username;
        $newUser->password = $passwordHash;

        if (!$newUser->save()) {
            return 'Регистрация не удалась.' . var_export($newUser->getErrors(), true);
        }

        $token = Token::generateNewToken($newUser->userId);

        if (empty($token)) {
            return 'Не удалось сгенерировать ключ доступа.';
        }

        return [
            "accessToken" => $token->accessToken,
        ];
    }
}
