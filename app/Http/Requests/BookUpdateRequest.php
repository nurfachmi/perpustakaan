<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('books.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publish_year' => 'required|date_format:Y',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'publish_year.date_format' => 'Tahun terbit harus berformat tahun YYYY'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'judul buku',
            'category_id' => 'kategori',
            'author' => 'penulis',
            'publish_year' => 'tahun terbit',
            'description' => 'sinopsis',
        ];
    }
}
