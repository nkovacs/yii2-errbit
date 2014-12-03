<?php

namespace nkovacs\errbit;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * WebErrorHandler sends errors to errbit.
 */
class WebErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @var boolean whether to enable javascript error notifier
     */
    public $jsNotifier = false;

    use ErrorHandlerTrait {
        ErrorHandlerTrait::register as traitRegister;
    }

    public function register()
    {
        $this->traitRegister();
        if ($this->jsNotifier) {
            Yii::$app->on(\yii\web\Application::EVENT_BEFORE_ACTION, function ($event) {
                Yii::$app->view->on(\yii\web\View::EVENT_BEFORE_RENDER, function ($event) {
                    $host = $this->errbit['host'];
                    if (Url::isRelative($host)) {
                        $host = '//' . $host;
                    }
                    $event->sender->registerJsFile(rtrim($host, '/') . '/javascripts/notifier.js', [
                        'position' => \yii\web\View::POS_HEAD,
                        'api_key' => 'b0e150f34e894c52357b9febae1fed5d'
                    ]);
                    $event->sender->registerJs(
                        'Airbrake.setKey(' . Json::encode($this->errbit['api_key']) . ');' .
                        'Airbrake.setHost(' . Json::encode($this->errbit['host']) . ');',
                        \yii\web\View::POS_HEAD
                    );
                });
            });
        }
    }
}
