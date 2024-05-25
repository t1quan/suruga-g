<?php

namespace App\Http\Controllers\Ajax;

use App\Core\Logger\Logger;
use App\Http\Controllers\Controller;
use App\Util\UtilFormSelect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class FormController
 * @package App\Http\Controllers\Ajax
 */
class FormController extends Controller
{

    // 郵便番号の入力から住所データを返す
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function selectZip(Request $request): JsonResponse
    {
        $res = $request->validate([
            'zip' => 'required|digits:7',
        ]);
        if(!$res){
            throw ValidationException::withMessages([
                'errMsg' => 'エラーが発生しました。再度やり直してください。'
            ]);
        }

        $code = $request->get('zip');

        $data = null;
        if($code){
            $data = UtilFormSelect::getByZip($code);
        }
        if(!$data) {
            Logger::errorTrace('Error occurred at ' . __METHOD__ , $code);
        }

        return response()->json([$data, 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public static function selectPref(Request $request): JsonResponse
    {
        $res = $request->validate([
            'pref' => 'required|numeric',
        ]);
        if(!$res){
            throw ValidationException::withMessages([
                'errMsg' => 'エラーが発生しました。再度やり直してください。'
            ]);
        }

        $code = $request->get('pref');

        $data = null;
        if($code){
            $data = UtilFormSelect::getByPref($code);
        }
        if(!$data) {
            Logger::errorTrace('Error occurred at ' . __METHOD__ , $code);
        }

        return response()->json([$data, 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT]);
    }
}
