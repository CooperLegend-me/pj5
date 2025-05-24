<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function reviews()
    {
        $reviews = Review::latest()->get();
        return view('reviews', compact('reviews'));
    }

    public function faq()
    {
        return view('faq');
    }

    public function calculator()
    {
        return view('calculator');
    }
} 