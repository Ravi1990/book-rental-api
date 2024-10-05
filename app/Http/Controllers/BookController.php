<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function search(Request $request)
    {
        $query= Book::query();

        if($request->has('title')){
            $query->where('title','like','%'.$request->input('title').'%');
        }
        if($request->has('genre')){
            $query->where('genre',$request->input('genre'));
        }

        return response()->json($query->get());
    }
}
