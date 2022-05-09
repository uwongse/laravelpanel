<?php

namespace App\Http\Requests\Admin\Movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;

class StoreMovie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.movie.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'synopsis' => ['nullable'],
            'duration' => ['nullable', 'integer'],
            'date' => ['sometimes', 'date'],
            'trailer' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
            'premiere' => ['sometimes', 'date'],
            'buy' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
            'update' => ['nullable', 'boolean'],
            'qulification'=> ['requiered'],
        ];
    }
    public function getActors(): array
{
    if ($this->has('actors')) {
        $actors = $this->get('actors');
        return array_column($actors, 'id');
    }
    return [];
}
public function getDirectors(): array
{
    if ($this->has('directors')) {
        $directors = $this->get('directors');
        return array_column($directors, 'id');
    }
    return [];
}
    public function getQualificationId(){
        if ($this->has('qualification')){
            return $this->get('qualification')['id'];
        }
        return null;
    }
    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
