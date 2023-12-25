<?php

namespace App\Http\Controller;

use App\Model\Note;
use Core\Database\Connection;
use Core\Http\Request;
use Core\Validation\Validation;

class NoteController
{
    public function __construct(
        private Connection $connection,
        private Request $request,
    ) {

    }
    public function index()
    {
        $notes = $this->connection->query("select * from notes order by created_on desc;")->get();

        return view("pages/notes/index", compact('notes'));
    }

    public function show(int $id)
    {
        $note = $this->connection->query(
            "select * from notes where id = :id",
            [
                'id' => $id
            ]
        )->findOrFail();

        return view("pages/notes/show", compact('note'));
    }

    public function create()
    {
        return view('pages/notes/create');
    }

    public function edit(int $id)
    {
        $note = $this->connection->query(
            "select * from notes where id = :id",
            [
                'id' => $id
            ]
        )->findOrFail();

        return view("pages/notes/edit", compact('note'));
    }

    public function update(int $id)
    {
        $data = $this->request->validate(['body' => ['required', "string"]]);

        $this->connection->query("update notes set body = :body where id = :id", [
            'id' => $id,
            ...$data
        ]);

        return response()->back();
    }

    public function store()
    {

        $data = request()->validate(['body' => ['required', "string"]]);

        $this->connection->query("INSERT INTO notes(body) VALUE(:body)", $data);

        return response()->redirect("/notes");
    }

    public function delete(int $id)
    {
        $this->connection->query("delete from notes where id = :id", compact('id'));
        return response()->back();
    }
}