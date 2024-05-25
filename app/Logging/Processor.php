<?php
namespace App\Logging;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Monolog\Processor\ProcessorInterface;

class Processor implements ProcessorInterface {

    public function __invoke(array $records) {

        // LogにUser情報を付与
        if (
            Request::path() !== 'login'
            && Auth::check()
        ) {
            $user = Auth::user();
            $loginId = $user->loginId;
        }else{
            $loginId = 'guest';
        }

        $records['extra'] += [
            'loginId' => $loginId
        ];

        $records['extra']['sid'] = substr(hash('sha256', session()->getId()),0,7);
        $input = Request::input();
        $oid = Request::header('X-Tenichi-Oid');
        $records['extra']['oid'] = $oid?? $input['oid']?? 'common';
        $records['extra']['requestId'] = $_SERVER['X_REQUEST_ID']?? 'unknown';

        return $records;

    }
}
