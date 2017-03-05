<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Category;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $args = [
            'list_items' => Book::paginate(10)
        ];

        return view('book/index', $args);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $args = [
            'categories' => Category::all()
        ];

        return view('book/create', $args);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'author' => 'required|string',
            'published_date' => 'required|date',
            'category_id' => 'required'
        ]);

        $fields = $request->only(['name', 'author', 'category_id']);

        $date_parts = explode('/', $request->input('published_date'));
        $fields['published_date'] = $date_parts[2].'-'.$date_parts[0].'-'.$date_parts[1];

        Book::create($fields);

        $request->session()->flash('msg', ['type' => 'success', 'text' => 'The book was successfully created']);
        return redirect(route('book.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $args = [
            'categories' => Category::all(),
            'item' => Book::find($id)
        ];

        return view('book/edit', $args);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'author' => 'required|string',
            'published_date' => 'required|date',
            'category_id' => 'required'
        ]);

        $fields = $request->only(['name', 'author', 'category_id']);

        $date_parts = explode('/', $request->input('published_date'));
        $fields['published_date'] = $date_parts[2].'-'.$date_parts[0].'-'.$date_parts[1];

        $book = Book::find($id);
        $book->fill($fields);
        $book->save();

        $request->session()->flash('msg', ['type' => 'success', 'text' => 'The book was successfully updated']);
        return redirect(route('book.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();

        try
        {
            Book::destroy($id);
            $request->session()->flash('msg', ['type' => 'success', 'text' => 'The book was successfully deleted']);
        }
        catch(Exception $e)
        {
            $request->session()->flash('msg', ['type' => 'danger', 'text' => 'There was a problem deleting the book']);
            DB::rollback();
        }

        DB::commit();
        return redirect(route('book.index'));
    }
}
