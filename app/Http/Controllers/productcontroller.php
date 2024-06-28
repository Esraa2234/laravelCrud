<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class productcontroller extends Controller
{
    public function index(){

        return view('products.index', ['products'=>product::latest()->paginate(4)]);
    }
    public function create(){
        return view('products.create');
        }
        public function store(Request $request){
            // validate data
            $request->validate([
                'name' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
                'description' => 'required',
                ]);
            // upload image
            // dd($request->all());
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            // dd($imageName);
            $product = new product;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->image = $imageName;

            $product->save();
            return back()->withSuccess('product create !!!!!');
            }

            public function edit($id){
                $product = product::where('id', $id)->first();
                return view('products.edit', ['product' => $product]);
            }
            public function update(Request $request, $id){
                    // validate data
            $request->validate([
                'name' => 'required',
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                'description' => 'required',
                ]);
                $product = product::where('id',$id)->first();
                if(isset($request->image)){
                // upload image
            // dd($request->all());
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            $product->image = $imageName;
                }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->save();
            return back()->withSuccess('product Updated !!!!!');
            }
            public function destroy($id){
                $product = product::where('id', $id)->first();
                $product->delete();
                return back()->withSuccess('product deleted !!!!!');
                }
                public function show($id){
                    $product = product::where('id', $id)->first();
                    return view('products.show', ['product' => $product]);
                    }

}
