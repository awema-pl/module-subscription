<?php

namespace AwemaPL\Subscription\Sections\Options\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOption extends FormRequest
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
        return [
            'name' => 'required|max:255|string',
            'price' => 'required|regex:/^\d{1,8}(\.\d{1,2})?$/'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => _p('subscription::requests.option.attributes.name', 'name'),
            'price' => _p('subscription::requests.option.attributes.price', 'price'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'price.regex' => _p('subscription::requests.option.messages.invalid_price_format', 'Invalid price format'),
        ];
    }
}
