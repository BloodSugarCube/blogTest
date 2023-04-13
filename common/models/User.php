<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "User".
 *
 * @property int $userId
 * @property string $email
 * @property string $password
 * @property string $username
 * @property int|null $isAdmin
 */
class User extends BaseUser implements IdentityInterface
{
    //Consts

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['email'], 'email']
        ]);
    }

    public function serializedData()
    {
        $serializedData = [];
        $serializedData['userId'] = $this->userId;
        $serializedData['username'] = $this->username;

        return $serializedData;
	}

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public static function userList(){
        return static::find()
            ->select(['userId', 'username'])
            ->all();
    }
    
    //Custom relations methods

    //Another custom methods
}
