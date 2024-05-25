<?php

namespace App\Http\Requests\Apply;

use App\Core\Logger\Logger;
use Illuminate\Foundation\Http\FormRequest;

class ApplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        //[ *2.追加：Validationルール記述箇所 ]
        // nullを許可する場合はnullableを付与
        return [
            'lastName' => ['required','string','max:16'],
            'firstName' => ['required','string','max:16'],
            'lastKana' => ['required','string','max:32'],
            'firstKana' => ['required','string','max:32'],
            'dobYear' => ['required','max:4'],
            'dobMonth' => ['required','max:2'],
            'dobDay' => ['required','max:2'],
            'gender' => ['required','numeric'],
            'telNumber' => ['required','string','max:13'],
            'mailAddress' => ['required','email','max:256'],
//            'mailAddressRe-enter' => ['required','email','max:256'],
            'currentOccupation' => ['required','numeric'],
            'zipCode' => ['required','max:7'],
            'prefecture' => ['required', 'numeric'],
            'city' => ['nullable', 'numeric'],
            'street' => ['nullable','string'],
            'station' => ['nullable','string'],
            'educationLevel' => ['nullable','numeric'],
            'graduationYear' => ['nullable','numeric'],
            'graduationStatus' => ['nullable','numeric'],
            'schoolName' => ['nullable','string'],
            'departmentName' => ['nullable','string'],
            'maritalStatus' => ['nullable','numeric'],
            'toeicScore' => ['nullable','numeric'],
            'toeflScore' => ['nullable','numeric'],
            'changeNumber' => ['nullable','numeric'],
            'managementExperience' => ['string','nullable'],
            'managementNumber' => ['nullable','numeric'],
            'otherPCSkill' => ['nullable','string','max:150'],
            'qualification' => ['nullable','string','max:1000'],
            'jobDescriptionA' => ['nullable','string','max:5000'],
            'jobDescriptionB' => ['nullable','string','max:5000'],
            'jobDescriptionC' => ['nullable','string','max:5000'],
            'jobDescriptionD' => ['nullable','string','max:5000'],
            'jobDescriptionE' => ['nullable','string','max:5000'],
            'pr' => ['nullable','string','max:1200'],
        ];
    }

    //[ *3.追加：Validationメッセージを設定（省略可） ]
    //function名は必ず「messages」となります。
    public function messages(): array
    {
        Logger::infoTrace('ApplyRequestForm - messages');
        $messages = array();
        $validation = self::rules();
        foreach($validation as $field => $rules){
            foreach($rules as $rule){
                $ary = explode(":", $rule);
                $attribute = false; // 初期化
                if(count($ary) > 1){
                    $rule = $ary[0];
                    $attribute = $ary[1];
                }
                $key = $field . '.' . $rule;
                $msg = null;
                switch($rule){
                    case 'required':
                        $msg = '必須項目です。';
                        break;
                    case 'numeric':
                        $msg = '数値を入力してください';
                        break;
                    case 'email':
                        $msg = 'Eメールの形式で入力して下さい';
                        break;
                    case 'max':
                        $msg = ( $attribute ? $attribute.'文字以下で入力してください。' : '' );
                        break;
                    default:
                        break;
                }
                if($msg){
                    $messages[$key] = $msg;
                }
            }
        }
        if(isset($mseeages['job_id.required'])){
            $messages['job_id.required']  = '対象の求人情報が取得できませんでした。';
        }

        return $messages;
    }
}
