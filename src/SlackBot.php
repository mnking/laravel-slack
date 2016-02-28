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
    protected $client;

    protected $bot;

    protected $channel;

    protected $username;

    protected $icon;

    protected $attachment = [];

    protected $header = [];

    protected $color;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

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

    public function header($array = [])
    {
        $this->header = $array;

        return $this;
    }

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

    public function color($color)
    {
        $this->color = $color;

        return $this;
    }

    public function bot($name)
    {
        $this->bot = config('slack.bot.' . $name);

        return $this;
    }

    public function to($recipient)
    {
        $this->channel = $recipient;

        return $this;
    }

    public function withName($sender)
    {
        $this->username = $sender;

        return $this;
    }

    public function avatar($icon)
    {
        $this->icon = sprintf(':%s:', $icon);

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    private function clearAttachment()
    {
        $this->attachment = [];
    }
}