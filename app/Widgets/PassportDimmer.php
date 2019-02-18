<?php

namespace App\Widgets;

use App\Passport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class PassportDimmer extends BaseDimmer
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
        $count = Passport::count();
        $string = trans_choice('Passports', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-book',
            'title'  => "{$count} {$string}",
            'text'   => "You have $count passports in your database. Click on button below to view all passports.",
            'button' => [
                'text' =>  'View All Passports',
                'link' => route('voyager.passports.index'),
            ],
            'image' =>  asset('passportdimmerimg.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', app(Passport::class));
    }
}
