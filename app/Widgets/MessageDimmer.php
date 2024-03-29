<?php

namespace App\Widgets;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class MessageDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Message::count();
        $string = 'Messages';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-bubble',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager::dimmer.message_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Berichten'),
                'link' => route('voyager.messages.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return app('VoyagerAuth')->user()->can('browse', Voyager::model('Message'));
    }
}
