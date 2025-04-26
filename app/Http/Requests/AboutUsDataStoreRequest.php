<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class AboutUsDataStoreRequest extends FailedValidation
{
    /**
     * Determine if the user is authorized to make this request.
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
        $rule = [
            'title' => 'required|string|max:150',
            'description' => 'required',
        ];

        if ($this->has("image_path") and $this->hasFile("image_path")) {
            $rule['image_path'] = 'required|mimes:jpeg,png,jpg';
        }

        return $rule;

    }

}
