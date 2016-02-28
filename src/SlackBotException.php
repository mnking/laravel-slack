<?php
/**
 * Created by PhpStorm.
 * User: Vuong
 * Date: 21-Feb-16
 * Time: 1:49 PM
 */

namespace Mnking\Slack;


class SlackBotException extends \Exception
{
    /**
     * The exception description.
     *
     * @var string
     */
    protected $message = 'We have some errors! Sorry about that';
}