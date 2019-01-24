<?php

namespace Modules\Filemanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateFileTypeCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:filemanager__filetypecategories,name,'.$this->old_name.',name|max:255',
            'folder' => 'required|max:255'
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
          'name.required' => 'Name is Required',
            'name.unique' => 'Name already exist',
            'folder.required' => 'folder is required'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
