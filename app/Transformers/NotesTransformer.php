<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 7/6/17
 * Time: 12:32 PM
 */

namespace App\Transformers;

use Carbon\Carbon;

/**
 * Class NotesTransformer
 *
 * @package App\Transformers
 */
class NotesTransformer extends Transformer
{
    /**
     * Transform the data.
     *
     * @param $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return [
            'uuid'          => get_data($data, 'uuid'),
            'title'         => get_data($data, 'title'),
            'notes'         => get_data($data, 'notes'),
            'created_at'    => Carbon::parse($data['created_at'])->toDateTimeString()
        ];
    }
}
