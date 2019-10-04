<?php

namespace OwowAgency\LaravelResources\Tests\Support\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestModelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required',
        ];
    }
}
