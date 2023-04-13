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
    private $articles;


    public function rules()
    {
        return [
            [['limit', 'userId', 'offset'], 'integer'],
            [['limit'], 'default', 'value' => '5'],
            [['offset'], 'default', 'value' => '0'],
        ];
    }

    public function getByLimitOffsetId()
    {
        if (!$this->validate()) {
            $this->addError('validate', 'Данные введены не соответственно своему типу.');
            return false;
        }

        $articleQuery = Article::find()
            ->limit($this->limit)
            ->offset($this->offset)
            ->andFilterWhere(['userId' => $this->userId])
            ->orderBy(['articleId' => SORT_DESC]);

        $articles = [];
        foreach ($articleQuery->each() as $article) {
            $articles[] = $article->serializeToArray();
        }

        if (empty($articles)) {
            $this->addError('articles', 'С такими значениями limit, offset и id статей не найдено.');
            return false;
        }

        $this->articles = $articles;

        return true;
    }

    public function getArticles()
    {
        return ["articles" => $this->articles];
    }
}