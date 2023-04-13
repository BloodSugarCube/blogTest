<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Token;
use common\models\User;

/**
 * Login form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $username;
    private $user;
    private $accessToken;


    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
            [['email'], 'email'],
            [['password', 'username'], 'string'],
            [['email'], 'unique', 'targetClass' => 'common\models\User', 'targetAttribute' => 'email'],
        ];
    }

    public function signUp()
    {
        if (!$this->validate()) {
            $this->addError('validate', 'Данные введены не соответственно своему типу.');
            return false;
        }

        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        $user = new User();
        $user->email = $this->email;
        $user->username = $this->username;
        $user->password = $passwordHash;

        if (!$user->save()) {
            $this->addError('user', 'Не удалось сохранить пользователя.');
            return false;
        }

        $token = Token::generateNewToken($user->userId);

        if (empty($token)) {
            $this->addError('token', 'Токен не сгенерировался.');
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