<?php

namespace frontend\components;

use yii\base\BootstrapInterface;

class Language implements BootstrapInterface{
    public $supportedLanguages = ['uz', 'en', 'de'];
    public function bootstrap($app){
        $cookieLanguage = $app->request->cookies['language'];
        if(isset($cookieLanguage) && in_array($cookieLanguage, $this->supportedLanguages)){
            $app->language = $app->request->cookies['language'];
        }
    }
}


?>