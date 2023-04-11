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
        $serializedData['text'] = $this->text;

        if (!empty($this->userId)) {
            $serializedData['user'] = $this->user->serializedData();
        }
        return $serializedData;
	}
    //Custom relations methods

    //Another custom methods
}