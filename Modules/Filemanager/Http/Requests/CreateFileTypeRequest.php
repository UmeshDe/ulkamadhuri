<?php

namespace Modules\Filemanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateFileTypeRequest extends BaseFormRequest
{
    public function rules()
    {
         return [
            'type' => 'required|unique:filemanager__filetypes,type|max:255',
            'folder' => 'required|max:255',
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
            'type.required' => 'Type name is required',
            'type.unique' => 'This type already exists',
            'folder.required' => 'Folder name is required',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
