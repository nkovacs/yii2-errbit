<?php

namespace nkovacs\errbit;

use Yii;
use Errbit\Errbit;
use yii\base\InvalidConfigException;

/**
 * ErrorHandlerTrait should be attached to an error handler.
 * It sends errors to errbit.
 */
trait ErrorHandlerTrait
{
    /**
     * @var string errbit api key
     */
    public $errbitApiKey;

    /**
     * @var string errbit host
     */
    public $errbitHost;

    /**
     * @var array errbit configuration
     */
    public $errbit;

    public function register()
    {
        $config = [
            'api_key' => $this->errbitApiKey,
            'host'    => $this->errbitHost,
        ];

        if (is_array($this->errbit)) {
            $this->errbit = array_merge($config, $this->errbit);
        }

        if ($this->errbit['api_key'] === null) {
            throw new InvalidConfigException('Errbit API key is required.');
        }
        if ($this->errbit['host'] === null) {
            throw new InvalidConfigException('Errbit host is required.');
        }

        Errbit::instance()
            ->configure($this->errbit);

        parent::register();
    }

    protected function logException($exception)
    {
        $opts = [];
        $controller = Yii::$app->controller;
        if ($controller !== null) {
            $opts['controller'] = $controller->uniqueId;
            if ($controller->action !== null) {
                $opts['action'] = $controller->action->id;
            }
            if ($controller instanceof UserInfoInterface) {
                $opts['user'] = $controller->getErrbitUserInfo();
            }
        }
        Errbit::instance()->notify($exception, $opts);
        parent::logException($exception);
    }
}
