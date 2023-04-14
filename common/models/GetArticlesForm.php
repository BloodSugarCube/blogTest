<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Token;
use common\models\Article;

/**
 * Login form
 */
class GetArticlesForm extends Model
{
    public $limit;
    public $offset;
    public $userId;
    private $articleQuery;


    public function rules()
    {
        return [
            [['limit', 'userId', 'offset'], 'integer'],
            [['limit'], 'default', 'value' => '5'],
            [['offset'], 'default', 'value' => '0'],
        ];
    }

    public function findArticles()
    {
        if (!$this->validate()) {
            $this->addError('validate', 'Данные введены не соответственно своему типу.');
            return false;
        }

        $articleQuery = Article::find()
            ->andFilterWhere(['userId' => $this->userId])
            ->orderBy(['articleId' => SORT_DESC])
            ->limit($this->limit)
            ->offset($this->offset);;
        $this->articleQuery = $articleQuery;

        return true;
    }

    public function getArticles()
    {
        $articles = [];
        foreach ($this->articleQuery->each() as $article) {
            $articles[] = $article->serializeToArray();
        }

        return ["articles" => $articles];
    }
}