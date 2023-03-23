<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $this->user_id,
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'Це поле повинно бути заповнене',
          'name.string' => 'Імя повинно бути стрічкою',
          'email.required' => 'Це поле повинно бути заповнене',
          'email.string' => 'Пошта повинна бути стрічкою',
          'email.email' => 'Ваша пошта має відповідати формату mail@some.domain',
          'email.unique' => 'Користувач з такою поштою вже існує',
        ];
    }
}
