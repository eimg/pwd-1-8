<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::all();

        return view("articles.index", [
            'articles' => $data,
        ]);
    }

    public function detail(string $id)
    {
        $article = Article::find($id);

        return view("articles.detail", [
            "article" => $article,
        ]);
    }
}
