<?php

namespace nkovacs\errbit;

/**
 * ConsoleErrorHandler sends errors to errbit.
 */
class ConsoleErrorHandler extends \yii\console\ErrorHandler
{
    use ErrorHandlerTrait;
}
