<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionCategory;
use Validator;

class QuestionCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $categories = QuestionCategory::all();
        
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'category'           => 'required|string|unique:wafutech_stackexchange_question_categories',
            'description'           => 'required',
                ];
    

    $validator = Validator::make(Input::all(), $rules);

     // Return back to form w/ validation errors & session data as input

     if($validator->fails()) {
        return $validator->messages();

    }

    $category = new QuestionCategory;
    $category->category = $request->category;
    $category->description = $request->description;
    $category->save();
    return 'Category created!';
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $category = QuestionCategory::findOrFail($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $category = QuestionCategory::findOrFail($id);
        return $category;
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
       $input = $request->all();
        $category = QuestionCategory::findOrFail($id);
        $category->update($input);
        return $category; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $category = QuestionCategory::findOrFail($id);
        $category->delete();
        return 'Deleted!';
    }
}
