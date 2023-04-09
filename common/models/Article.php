<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Article".
 *
 * @property int $articleId
 * @property int $userId
 * @property string|null $text
 */
class Article extends BaseArticle
{
    //Consts

    public function rules()
    {
        return array_merge(parent::rules(), [
            //Custom rules
        ]);
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['articleId'] = $this->articleId;
        $serializedData['userId'] = $this->userId;
        $serializedData['text'] = $this->text;
        
        return $serializedData;
	}
    //Custom relations methods

    //Another custom methods
}