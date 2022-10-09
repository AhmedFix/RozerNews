<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticaleRequest extends FormRequest
{
    /**
     * Determine if the articale is authorized to make this request.
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
            'title' => 'required|unique:articales',
            'description' => 'required',
            'poster' => 'sometimes|nullable|image',
            'pdf_url' => 'required',
            'type' => 'required',
            'release_date' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'page_count' => 'required'
            
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $articale = $this->route()->parameter('articale');

            $rules['title'] = 'required|unique:articales,id,' . $articale->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
