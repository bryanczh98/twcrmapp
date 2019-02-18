<?php

namespace App\Widgets;

use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class TransactionDimmer extends BaseDimmer
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
        $count =  Transaction::count();
        $string = trans_choice('Transactions', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-file-text',
            'title'  => "{$count} {$string}",
            'text'   => "You have $count transactions in your database. Click on button below to view all transactions.",
            'button' => [
                'text' => 'View All Transactions',
                'link' => route('voyager.transactions.index'),
            ],
            'image' => asset('transactiondimmerimg.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', app(Transaction::class));
    }
}