<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Category;
use Auth, DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $filters = [];
        if($request->has('filters')) {

            //Initialize query builder this way so results are a Book object, not PHP StdClass
            $book_query = Book::setQuery(DB::table('books'));
            if($request->has('search')){

                $book_query->where(function ($query) use ($request) {
					$query->where('name', 'like', '%'.$request->input('search').'%')
						->orWhere('author', 'like', '%'.$request->input('search').'%');
				});
                $filters['search'] = $request->input('search');
            }
            if($request->has('category_id')){
                
                $book_query->where('category_id', $request->input('category_id'));
                $filters['category_id'] = $request->input('category_id');
            }
            if($request->has('available')){
                
                $book_query->whereNull('user_id');
                $filters['available'] = $request->input('available');
            }

            $book_list = $book_query->paginate(10);
            $book_list->appends($request->except('page')); //Append query string in pagination

        }else{
            $book_list = Book::paginate(10);
        }

        $args = [
            'list_items' => $book_list,
            'categories' => Category::all(),
            'filters' => $filters
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

    /**
     * Update user that borrowed the book
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function borrow_book(Request $request, $id)
    {
        $book = Book::find($id);
        
        if($book->user){
            $book->user()->dissociate();
            $type = 'deliver';
        }else{
            $book->user()->associate(Auth::user());
            $type = 'borrow';
        }

        $book->save();

        return response()->json(['type' => $type, 'user_name' => Auth::user()->name, 'book' => $book]);
    }
}
