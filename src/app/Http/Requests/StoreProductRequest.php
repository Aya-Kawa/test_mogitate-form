<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0|max:10000',
            'image' => 'required|file|mimes:jpeg,png',
            'seasons' => 'required|array|min:1',
            'seasons.*' => 'integer|exists:seasons,id',
            'description' => 'required|string|max:120',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.max' => '商品名は100文字以内で入力してください',

            'price.required' => '値段を入力してください',
            'price.integer' => '値段を入力してください',
            'price.min' => '0〜10000円以内で入力してください',
            'price.max' => '0〜10000円以内で入力してください',

            'image.required' => '画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'seasons.required' => '季節を選択してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $messages = $this->messages();
            $errors = $validator->errors();

            $add = function (string $field, string $message) use ($errors) {
                if (!in_array($message, $errors->get($field), true)) {
                    $errors->add($field, $message);
                }
            };

            if ($this->input('name') === null || $this->input('name') === '') {
                $add('name', $messages['name.max']);
            }

            if ($this->input('price') === null || $this->input('price') === '') {
                $add('price', $messages['price.integer']);
                $add('price', $messages['price.min']);
                $add('price', $messages['price.max']);
            }

            if (!$this->hasFile('image')) {
                $add('image', $messages['image.mimes']);
            }

            if ($this->input('description') === null || $this->input('description') === '') {
                $add('description', $messages['description.max']);
            }
        });
    }
}


