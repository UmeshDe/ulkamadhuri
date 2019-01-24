<?php

namespace Modules\Filemanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateFileStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'status' => 'required|unique:filemanager__filestatuses,status,'.$this->old_status.',status|max:255',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'status.required' => 'Please Enter Status',
            'status.unique' => 'Status Already Exist',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
