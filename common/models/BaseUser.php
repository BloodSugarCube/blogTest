<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $userId
 * @property string $email
 * @property string $password
 * @property string $username
 * @property int|null $isAdmin
 */
class BaseUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
            [['isAdmin'], 'integer'],
            [['email', 'password', 'username'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'email' => 'Email',
            'password' => 'Password',
            'username' => 'Username',
            'isAdmin' => 'Is Admin',
        ];
    }
}
