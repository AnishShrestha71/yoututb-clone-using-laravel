<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function store(Channel $channel)
    {
        return $channel->subscription()->create([
            'user_id' => Auth::user()->id
        ]);
    }

    public function delete(Channel $channel, Subscription $subscription)
    {
        $subscription->delete(); 
        return response()->json([]);
    }
}
