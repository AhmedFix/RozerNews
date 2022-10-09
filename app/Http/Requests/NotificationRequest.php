<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the notification is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|unique:push_notifications',
            'body' => 'required',
            'img' => 'sometimes|nullable|image',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $notification = $this->route()->parameter('notification');

            $rules['title'] = 'required|unique:push_notifications,id,' . $notification->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
