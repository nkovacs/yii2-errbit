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

    /**
     * @var array additional js options
     * Keys are option names, e.g. currentUser, which will call Airbrake.setCurrentUser
     */
    public $jsOptions = [];

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

                    $js = 'Airbrake.setKey(' . Json::encode($this->errbit['api_key']) . ');';
                    $js .= 'Airbrake.setHost(' . Json::encode($this->errbit['host']) . ');';
                    if (isset($this->errbit['environment_name'])) {
                        $js .= 'Airbrake.setEnvironment(' . Json::encode($this->errbit['environment_name']) . ');';
                    }

                    if (is_array($this->jsOptions)) {
                        foreach ($this->jsOptions as $key => $value) {
                            $js .= 'Airbrake.set' . ucfirst($key) . '(' . Json::encode($value) . ');';
                        }
                    }

                    $event->sender->registerJs(
                        $js,
                        \yii\web\View::POS_HEAD
                    );
                });
            });
        }
    }
}
