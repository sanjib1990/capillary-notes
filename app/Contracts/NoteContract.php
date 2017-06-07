<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 7/6/17
 * Time: 12:16 PM
 */

namespace App\Contracts;

/**
 * Interface NoteContract
 *
 * @package App\Contracts
 */
interface NoteContract
{
    /**
     * Get List of notes
     *
     * @return mixed
     */
    public function getList();

    /**
     * Get notes by Uuid.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid);

    /**
     * Store notes.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data);

    /**
     * Update notes.
     *
     * @param string $uuid
     * @param array  $data
     *
     * @return mixed
     */
    public function updateNote(string $uuid, array $data);

    /**
     * soft delete a note.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function deleteNote(string $uuid);
}
