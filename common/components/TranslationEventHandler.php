<?php

namespace common\components;

use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler {

    public static function handleMissingTranslation(MissingTranslationEvent $event){
        $event->translatedMessage = '[['.$event->message.' - '.$event->category.' - '.$event->language.']]';
    }

}



?>
