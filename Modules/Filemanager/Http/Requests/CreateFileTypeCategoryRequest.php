<?php

namespace Modules\Filemanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateFileTypeCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:filemanager__filetypecategories,name|max:255',
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
            'name.required' => 'Category name is required',
            'name.unique'  => 'This category already exists',
            'folder.required' =>'Folder name is required'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
