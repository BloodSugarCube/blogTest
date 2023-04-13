<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Token;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    private $user;
    private $accessToken;


    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['password'], 'string'],
        ];
    }

    public function loginByEmail()
    {
        if (!$this->validate()) {
            $this->addError('error', 'Данные введены не соответственно своему типу.');
            return false;
        }

        $user = User::findByEmail($this->email);

        if (empty($user)) {
            $this->addError('error', 'Не найден пользователь по этому e-mail.');
            return false;
        }

        if (!Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError('error', 'Пароль не подходит данному пользователю.');
            return false;
        }

        $token = Token::generateNewToken($user->userId);

        if (empty($token)) {
            $this->addError('error', 'Токен не сгенерировался.');
            return false;
        }

        $this->accessToken = $token->accessToken;

        return true;
    }

    public function getToken()
    {
        return ['accessToken' => $this->accessToken];
    }
}