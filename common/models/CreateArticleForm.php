<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Token;
use common\models\Article;

/**
 * Login form
 */
class CreateArticleForm extends Model
{
    public $text;

    public $accessToken;
    private $article;


    public function rules()
    {
        return [
            [['text', 'accessToken'], 'required'],
            [['text', 'accessToken'], 'string'],
        ];
    }

    public function createArticle()
    {
        if (!$this->validate()) {
            $this->addError('validate', 'Данные введены не соответственно своему типу.');
            return false;
        }

        $accessToken = $this->accessToken;
        $token = Token::find()
            ->where(['accessToken' => $accessToken])
            ->one();

        if (empty($token)) {
            $this->addError('accessToken', 'Необходимо указать действующий accessToken.');
            return false;
        }

        if (empty($this->text)) {
            $this->addError('text', 'Необходимо указать text.');
            return false;
        }

        $article = new Article;
        $article->userId = $token->userId;
        $article->text = $this->text;

        if (!$article->save()) {
            $this->addError('article', 'Не удалось сохранить статью');
            return false;
        };

        $this->article = $article->serializeToArray();

        return true;
    }

    public function getArticle()
    {
        return ["article" => $this->article];
    }
}