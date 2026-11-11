<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('domain_name')) {
            $this->merge([
                'domain_name' => strtolower(trim($this->domain_name)),
            ]);
        }

        if ($this->has('auto_renew')) {
            $this->merge([
                'auto_renew' => $this->boolean('auto_renew'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'domain_name' => [
                'required', 'string', 'max:253',
                'regex:/^(?!-)[a-z0-9-]{1,63}(?<!-)(\.[a-z0-9-]{1,63})*\.[a-z]{2,}$/',
                Rule::unique('domains', 'domain_name')
                    ->where('user_id', $this->user()->id)
                    ->ignore($this->route('domain')?->id),
            ],
            'registrar'     => ['nullable', 'string', 'max:255'],
            'purchase_date' => ['nullable', 'date'],
            'expiry_date'   => ['required', 'date', 'after_or_equal:purchase_date'],
            'auto_renew'    => ['sometimes', 'boolean'],
        ];
    }
}