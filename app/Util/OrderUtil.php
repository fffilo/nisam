<?php

namespace App\Util;

use App\User;
use App\Models\Admin;
use App\Models\Order;
use App\Util\UserUtil;
use DB;

class OrderUtil{

    public static function todayOrder($group_id){
        $order = OrderUtil::today();
        if($order == null){
            $order = new Order;
            $lifetime = Admin::getValue($group_id, 'vote_expires');
            $time = "+10 min";
            if($lifetime->count() > 0){
                $first = $lifetime->first();
                $time = $first->value;
            }
            $order->date = date('Y-m-d H:i:s', strtotime($time));
            $order->user_id = UserUtil::nextUser($group_id)->id;
            $order->save();
        }

        return $order;
    }

    public static function today(){
        return Order::where('date', '>', date('Y-m-d 00:00:00'))->where('date', '<', date('Y-m-d 23:59:59'))->first();
    }

    public static function isExpired($order){
        if (date("Y-m-d H:i:s") >= $order->date){
            $order->status = "FINISHED";
            $order->place_id = OrderUtil::topPlace($order->id);
            $order->save();
            return true;
        }
        return false;
    }
    public static function topPlace($orderId){
        $votes = DB::table('vote')
            ->select(DB::raw('count(*) as vote_count, order_id, place_id'))
            ->where('order_id', '=', $orderId)
            ->groupBy('place_id')
            ->orderBy('vote_count', 'DESC')
            ->first();

        return $votes->place_id;
    }
}
