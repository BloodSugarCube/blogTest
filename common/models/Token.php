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
class Token extends BaseToken
{
    //Consts

    public function rules()
    {
        return array_merge(parent::rules(), [
            //Custom rules
        ]);
    }

    //Custom relations methods

    //Another custom methods
}
