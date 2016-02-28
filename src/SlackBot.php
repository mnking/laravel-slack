<?php
/**
 * Created by PhpStorm.
 * User: Vuong
 * Date: 21-Feb-16
 * Time: 1:00 PM
 */

namespace Mnking\Slack;


use GuzzleHttp\Client;

class SlackBot
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var
     */
    protected $bot;

    /**
     * @var
     */
    protected $channel;

    /**
     * @var
     */
    protected $username;

    /**
     * @var
     */
    protected $icon;

    /**
     * @var array
     */
    protected $attachment = [];

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var
     */
    protected $color;

    /**
     * SlackBot constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    /**
     * @param $text
     * @throws SlackBotException
     */
    public function send($text)
    {
        if (! $this->bot) {
            throw new SlackBotException('Please set a bot name first');
        }

        if ($this->attachment) {
            $json['fields'] = $this->attachment;
            $json['color'] = $this->color;
            $json += $this->header;
        }

        $json['text'] = $text;
        $json['channel'] = $this->channel;
        $json['username'] = $this->username;
        $json['icon_emoji'] = $this->icon;

        $this->getClient()->request('POST', $this->bot, [
            'json' => $json
        ]);

        $this->clearAttachment();
    }

    /**
     * @param array $array
     * @return $this
     */
    public function header($array = [])
    {
        $this->header = $array;

        return $this;
    }

    /**
     * @param $title
     * @param $value
     * @param $color
     * @return $this
     */
    public function attachment($title, $value, $color)
    {
        $this->color = $color;

        $this->attachment = array_merge($this->attachment, [
            [
                'title' => $title,
                'value' => $value
            ]
        ]);

        return $this;
    }

    /**
     * @param $color
     * @return $this
     */
    public function color($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param $bot
     * @return $this
     */
    public function bot($bot)
    {
        if (! $this->isUrl($bot)) {
            $bot = config('slack.bot.' . $bot);
        }

        $this->bot = config('slack.bot.' . $bot);

        return $this;
    }

    /**
     * @param $recipient
     * @return $this
     */
    public function to($recipient)
    {
        $this->channel = $recipient;

        return $this;
    }

    /**
     * @param $sender
     * @return $this
     */
    public function withName($sender)
    {
        $this->username = $sender;

        return $this;
    }

    /**
     * @param $icon
     * @return $this
     */
    public function avatar($icon)
    {
        $this->icon = sprintf(':%s:', $icon);

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * @return $this
     */
    private function clearAttachment()
    {
        $this->attachment = [];

        return $this;
    }

    private function isUrl($url)
    {
        return ! filter_var($url, FILTER_VALIDATE_URL) === FALSE;
    }
}