<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeHighlightiesStoreRequest extends FailedValidation
{
    /**
     * Determine if the user is authorized to make this request.
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
            'description_one' => 'required|string|max:350',
        ];

        if ($this->has("description_two") and $this->description_two) {
            $rule['description_two'] = 'required|string|max:350';
        }
        if ($this->has("description_three") and $this->description_three) {
            $rule['description_three'] = 'required|string|max:350';
        }
        if ($this->has("image_path") and $this->hasFile("image_path")) {
            $rule['image_path'] = 'required|mimes:jpeg,png,jpg';
        }
        if ($this->has("small_image_path") and $this->hasFile("small_image_path")) {
            $rule['small_image_path'] = 'required|mimes:jpeg,png,jpg';
        }

        return $rule;

    }
}
