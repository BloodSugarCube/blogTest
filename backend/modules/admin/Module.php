<?php

namespace backend\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // путь к директории layouts модуля
        \Yii::$app->setLayoutPath('@backend/modules/admin/views/layouts');
        // файл "admin.php"
        \Yii::$app->layout = '/admin';
    }
}
