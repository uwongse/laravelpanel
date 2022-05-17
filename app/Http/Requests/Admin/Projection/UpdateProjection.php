<?php

namespace App\Http\Requests\Admin\Projection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateProjection extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.projection.edit', $this->projection);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hour' => ['nullable','string'],
            'release_date' => ['nullable','string'],
            'movie' => ['required'],
            'room' => ['required'],
            'cinema' => ['required'],

        ];
    }
    public function getMovieId(){
        if ($this->has('movie')){
            return $this->get('movie')['id'];
        }
        return null;
    }
    public function getRoomId(){
        if ($this->has('room')){
            return $this->get('room')['id'];
        }
        return null;
    }
    public function getCinemaId(){
        if ($this->has('cinema')){
            return $this->get('cinema')['id'];
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
