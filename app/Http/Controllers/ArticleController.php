<?php

namespace App\Http\Controllers;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Exceptions\Handler;

class ArticleController extends Controller
{
    //Article Controller
	public function index()
    {
        return Article::all();
    }

    public function show(Article $article)
    {
		//$name = $request->input('name');
        return $article;
    }

    public function store(Request $request)
    {
		/*$email=$request['email'];
        $first_name=$request['first_name'];
        $password=bcrypt($request['password']);

        $User=new User();
        $User->email=$email;
        $User->first_name=$first_name;
        $User->password=$password;

        $User->save();

        return redirect()->route('dashboard');*/
		
		/*$name = $request->input('name');
		print_r($name);
		return Response::json(["response" => "ok"]);
		
		exit;*/
        $article = Article::create($request->all());

        return response()->json($article, 201);
		
		/*$response_array = array();
		$response_array['Object created'] = true;
		$response_code = 201;
		$response = Response::json($response_array, $response_code);*/
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
