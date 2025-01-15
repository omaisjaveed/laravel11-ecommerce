<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slide;

class HomeController extends Controller
{
    

   
    public function index()
    {
        $slides = Slide::where('status' , 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $fproducts = Product::where('featured', 1)->get()->take(8);
        // $slides = Slide::where('status', 1)->limit(3)->get();
        return view('index',compact('slides','categories','products','fproducts'));
    }

    public function contact(){
        return view('contact');
    }

    public function contact_store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'comment' => 'required',
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();


        return redirect()->route('user.contact')->with('status','Information has been Submitted');
    } 

    public function search(Request $request){
        $query = $request->input('query');
        $result = Product::where("name","LIKE","%{$query}%");
        return response()->json($result);
    }
}
