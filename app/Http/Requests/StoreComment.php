<?php

namespace App\Http\Requests;

use App\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreComment extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $level = 1;

        // Check if we are replying to a comment
        // If so, check how many levels of nested replies we have so far.
        if ($this->parent_id) {
            $post = null;
            $parent = Comment::findOrFail($this->parent_id);

            // Get the 1st-level comment
            while (isset($parent->parent)) {
                $level++;
                $parent = $parent->parent;
            }
        }

        $this->merge([
            'user_name' => strip_tags($this->user_name),
            'body' => strip_tags($this->body),
            'level' => $level,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => [Rule::requiredIf(function () {
                return empty($this->parent_id);
            }), 'numeric', 'nullable'],
            'parent_id' => [Rule::requiredIf(function () {
                return empty($this->post_id);
            }), 'numeric', 'nullable'],
            'user_name' => 'required|string',
            'body' => 'required|string',
            'level' => 'required|numeric|min:1|max:3',
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
            'level' => 'comment level',
        ];
    }
}
