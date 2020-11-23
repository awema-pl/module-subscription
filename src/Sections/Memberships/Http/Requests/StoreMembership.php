<?php

namespace AwemaPL\Subscription\Sections\Memberships\Http\Requests;

use AwemaPL\Subscription\Sections\Options\Models\Option;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMembership extends FormRequest
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
            'user_id' => 'bail|required|exists:' . config('auth.providers.users.model') . ',id|unique:'.config('subscription.database.tables.memberships').',user_id',
            'option_id' => 'required|exists:' . Option::class . ',id',
            'expires_at' => 'required',
            'comment' => 'nullable|max:65535|string',
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
            'user_id' => _p('subscription::requests.membership.attributes.user_id', 'user'),
            'option_id' => _p('subscription::requests.membership.attributes.option_id', 'option'),
            'comment' => _p('subscription::requests.membership.attributes.comment', 'comment'),
            'expires_at' => _p('subscription::requests.membership.attributes.expiration_date', 'expiration date'),
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
            'unique' => _p('subscription::requests.membership.messages.user_has_membership', 'This user already has membership.'),
        ];
    }
}
