<?php

namespace App\Models;

use Carbon\Carbon;
use App\Contracts\NoteContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Note
 *
 * @package App\Models
 */
class Note extends Model implements NoteContract
{
    /**
     * To avoid mass assignment.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'title', 'notes', 'cookie_id', 'status'];

    /**
     * Type cast certain keys for response.
     *
     * @var array
     */
    public $casts   = ['status' => 'bool'];

    /**
     * Get List of notes
     *
     * @return mixed
     */
    public function getList()
    {
        return $this
            ->where('cookie_id', request()->cookie_id)
            ->where('status', true)
            ->get();
    }

    /**
     * Get notes by Uuid.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    /**
     * Store notes.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->create([
            'uuid'          => uuid(),
            'title'         => get_data($data, 'title'),
            'cookie_id'     => request()->cookie_id,
            'notes'         => get_data($data, 'notes'),
            'created_at'    => Carbon::now()
        ]);
    }

    /**
     * Update notes.
     *
     * @param string $uuid
     * @param array  $data
     *
     * @return mixed
     */
    public function updateNote(string $uuid, array $data)
    {
        return $this->getByUuid($uuid)->update([
            'title'         => get_data($data, 'title'),
            'notes'         => get_data($data, 'notes'),
            'updated_at'    => Carbon::now()
        ]);
    }

    /**
     * soft delete a note.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function deleteNote(string $uuid)
    {
        return $this->getByUuid($uuid)->update([
            'status'        => false,
            'updated_at'    => Carbon::now()
        ]);
    }
}
