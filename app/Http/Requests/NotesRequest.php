<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 7/6/17
 * Time: 12:40 PM
 */

namespace App\Http\Requests;

/**
 * Class NotesRequest
 *
 * @package App\Http\Requests
 */
class NotesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'notes' => 'required'
        ];
    }
}
