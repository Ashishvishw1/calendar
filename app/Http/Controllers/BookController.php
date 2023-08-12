<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{


    public function index(){

        $book=Book::select('id','name','Author','publish_date')->get();
     
        return response()->json($book);//Sending response in json format
    }
    public function store(Request $r){
$book = new Book;
$book->name = $r->name;
$book->Author = $r->Author;
$book->publish_date = $r->publish_date;
$book->save();
return response()->json(["message"=>"Book Added"],201);


    }



    public function show(Book $id){

$book=Book::find($id);
return $book? response()->json($book) :  response()->json(["message" => "Book Not Found"], 404);

    }


    public function update(Request $r,$id){


        if (Book::where('id',$id)->exists()) {
$book=Book::find($id);
$book->name = is_null($r->name) ?   $book->name :$r->name;
$book->Author = is_null($r->Author) ?   $book->name :$r->Author;
$book->publish_date = is_null($r->publish_date) ?   $book->name :$r->publish_date;
$book->save();

return response()->json([


    "meassage"=>"Book updated"],404
);
            # code...
        }else{

            return response()->json([


                "meassage"=>"Book not found"],404
            );
        }



    }


    public function destroy($id){


        if (Book::find($id)->exists()) {


            $book = Book::find($id);
            $book->delete();


            return response()->json([


                "meassage"=>"record Deleted"],404
            );
            # code...
        }
        else
        {


            return response()->json([


                "meassage"=>"Book not found"],404
            );
        }
    }



}
