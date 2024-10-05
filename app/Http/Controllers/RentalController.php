<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueNotice;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    public function rent(Request $request){
        $validator = Validator::make($request->all(),[
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $book = Book::find($request->input('book_id'));

         // Check if the book is already rented -- (In real world expample it should be done with stock options, but sticking to the project specification)
        if (Rental::where('book_id', $book->id)->whereNull('return_at')->exists()) {
            return response()->json(['message' => 'Book already rented'], 400);
        }

        // Rent the book
        $rental = new Rental();
        $rental->user_id = $request->input('user_id');
        $rental->book_id = $book->id;
        $rental->rented_at = Carbon::now();
        $rental->due_at = Carbon::now()->addWeeks(2);
        $rental->status = 'rented';
        $rental->save();

        return response()->json(['message' => 'Book rented successfully', 'rental' => $rental]);
    }
    public function return(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'rental_id' => 'required|exists:rentals,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $rental = Rental::find($request->input('rental_id'));
        //Again retun already shoudl be done with stock but just keeping it simple for this test
        if ($rental->return_at !== null) {
            return response()->json(['message' => 'Book already returned'], 400);
        }

        $rental->return_at = Carbon::now();
        $rental->save();

        return response()->json(['message' => 'Book returned successfully']);
    }

    public function history(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $rentals = Rental::where('user_id', $request->input('user_id'))
                        ->with('book')
                        ->get();

        return response()->json($rentals);
    }

    public function markOverdue()
    {
        $overdueRentals = Rental::whereNull('return_at')
                                ->where('due_at', '<', Carbon::now())
                                ->update(['status' => 'overdue']);

        return response()->json(['message' => 'Overdue rentals updated']);
    }

    public function sendOverdueEmails()
    {
        $overdueRentals = Rental::where('due_at', '<', Carbon::now())
            ->get();

        foreach ($overdueRentals as $rental) {
            $rental->status = 'overdue';
            $rental->save();
            Mail::to($rental->user->email)->send(new OverdueNotice($rental));
        }

        return response()->json(['message' => 'Overdue emails sent.']);
    }

    public function stats()
    {
        $mostPopularBook = Rental::select('book_id', \DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderBy('total', 'desc')
            ->first();

        $leastPopularBook = Rental::select('book_id', \DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderBy('total', 'asc')
            ->first();

        $mostOverdueBook = Rental::where('status', 'overdue')
            ->select('book_id', \DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderBy('total', 'desc')
            ->first();
        //For least popular just checking most and least not same in cased when both are same count
        // Also lease popular logic can be diffrent if we check books which are never rented (Based on requirement we can build logic around it)
        return response()->json([
            'most_popular' => $mostPopularBook ? $mostPopularBook->book->title : 'None',
            'least_popular' => $leastPopularBook ? ($mostPopularBook->book->title ==$leastPopularBook->book->title?'None':$leastPopularBook->book->title) : 'None',
            'most_overdue' => $mostOverdueBook ? $mostOverdueBook->book->title : 'None',
        ]);
    }
}
