<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\SignupForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        return \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->loginByEmail()) {
            return $model->getToken();
        } else {
            $errors = $model->getErrors();
            return $errors;
        }
    }

    public
    function actionSignup()
    {
        $model = new SignupForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->signUp()) {
            return $model->getToken();
        } else {
            $errors = $model->getErrors();
            return $errors;
        }
    }
}
