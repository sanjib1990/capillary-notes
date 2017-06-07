<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 7/6/17
 * Time: 12:14 PM
 */

namespace App\Http\Controllers;

use App\Utils\Transformer;
use App\Contracts\NoteContract;
use App\Http\Requests\NotesRequest;
use App\Transformers\NotesTransformer;

/**
 * Class NoteController
 *
 * @package App\Http\Controllers
 */
class NoteController extends Controller
{
    /**
     * @var NoteContract
     */
    private $note;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * NoteController constructor.
     *
     * @param NoteContract $note
     * @param Transformer  $transformer
     */
    public function __construct(NoteContract $note, Transformer $transformer)
    {
        $this->note         = $note;
        $this->transformer  = $transformer;
    }

    /**
     * Get list of notes.
     *
     * @return mixed
     */
    public function get()
    {
        if (request()->uuid) {
            return $this->getByUuid();
        }

        $notes  = $this
            ->transformer
            ->process($this->note->getList(), new NotesTransformer());

        return response()->jsend($notes, trans('api.success'));
    }

    /**
     * Get specific notes.
     *
     * @return mixed
     */
    private function getByUuid()
    {
        $note   = $this
            ->transformer
            ->process($this->note->getByUuid(request()->uuid), new NotesTransformer());

        return response()->jsend($note, trans('api.success'));
    }

    /**
     * Create a note.
     *
     * @param NotesRequest $request
     *
     * @return mixed
     */
    public function create(NotesRequest $request)
    {
        $note   = $this
            ->transformer
            ->process(
                $this
                    ->note
                    ->store($request->all()),
                new NotesTransformer()
            );

        return response()->jsend($note, trans('api.success'), 201);
    }

    /**
     * Update a note.
     *
     * @param NotesRequest $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(NotesRequest $request)
    {
        $this->note->updateNote($request->uuid, $request->all());

        return response(null, 205);
    }

    /**
     * Delete a note.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete()
    {
        $this->note->deleteNote(request()->uuid);

        return response(null, 204);
    }
}
