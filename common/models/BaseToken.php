<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Token".
 *
 * @property int $tokenId
 * @property int $userId
 * @property string|null $accessToken
 */
class BaseToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId'], 'integer'],
            [['accessToken'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tokenId' => 'Token ID',
            'userId' => 'User ID',
            'accessToken' => 'Access Token',
        ];
    }
}
