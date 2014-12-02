<?php

namespace nkovacs\errbit;

/**
 * WebErrorHandler sends errors to errbit.
 */
class WebErrorHandler extends \yii\web\ErrorHandler
{
    use ErrorHandlerTrait;
}
