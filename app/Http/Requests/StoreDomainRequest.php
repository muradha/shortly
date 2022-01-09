<?php

namespace App\Http\Requests;

use App\Rules\ValidateDnsRule;
use App\Rules\ValidateDomainNameRule;
use App\Rules\DomainLimitGateRule;
use App\Rules\ValidateExternalDomainNameRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
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
            'name' => ['required', 'url', 'max:255', new DomainLimitGateRule($this->user()), new ValidateDomainNameRule(), new ValidateDnsRule()],
            'index_page' => ['nullable', 'url', 'max:255', new ValidateExternalDomainNameRule($this->name)],
            'not_found_page' => ['nullable', 'url', 'max:255', new ValidateExternalDomainNameRule($this->name)]
        ];
    }
}
