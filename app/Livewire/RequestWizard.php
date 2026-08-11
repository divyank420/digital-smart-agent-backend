<?php

namespace App\Livewire;

use Livewire\Component;

class RequestWizard extends Component
{
    public function render()
    {
        return view('livewire.request-wizard');
    }

    protected function rulesStep1()
    {
        return [
            'company_name' => 'required|min:3|max:150',
            'owner_name' => 'required|min:3|max:150',

            'mobile' => [
                'required',
                'digits:10',
                'regex:/^[6-9][0-9]{9}$/',
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ]
        ];
    }
}
