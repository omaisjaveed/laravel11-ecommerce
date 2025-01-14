<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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
}
