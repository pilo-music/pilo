<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "order_by" => [Rule::in(["id", "play_count", "created_at", "title_en", "title"])],
            "order_direction" => [Rule::in(["asc", "desc"])],
            "page" => ["integer", "max:30"],
            "count" => ["integer", "max:20"],
            "artist_id" => ["integer", Rule::exists("artists", "id")]
        ];
    }
}
