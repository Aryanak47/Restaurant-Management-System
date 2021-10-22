<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::paginate(5);
        return view("management.menu")->with('menus',$menus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view("management.createMenu")->with("categories", $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:menus|max:255',
            'category_id'=>'required|numeric',
            'price'=>'required|numeric',
            'description'=>'required|max:500',
        ]);
        $imageName = "no-img.png";
        if($request->image){
            $request->validate([
                'image'=>'nullable|file|image|mimes:jpeg,jpg,png||max:10000'
            ]);
            $imageName  = date('YmdHis') . "." . $request->image->extension();
            $request->image->move(public_path('/images/menu_images'), $imageName);
        }
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->image = $imageName;
        $menu->save();
        return redirect("/management/menu")->with("status",$request->name. ' is successfully saved in database !');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $categories = Category::all();
        return view('management/updateMenu')->with(compact('menu', 'categories'));
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
        $request->validate([
            'name'=>'required|max:255',
            'category_id'=>'required|numeric',
            'price'=>'required|numeric'
        ]);
        $menu = Menu::find($id);
        if($request->image){
            $request->validate([
                'image'=>'nullable|file|image|mimes:jpeg,jpg,png||max:5000'
            ]);
            if($menu->image != "no-img.png"){
                unlink(public_path('images/menu_images'.'/'.$menu->image));
            }
            $imageName  = date('YmdHis') . "." . $request->image->extension();
            $request->image->move(public_path('/images/menu_images'), $imageName);
            $menu->image = $imageName;
        }
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->category_id = $request->category_id;
        $menu->description = $request->description;
        $menu->save();
        return redirect("/management/menu")->with("status","Menu updated sucessfully !");
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect("/management/menu")->with("status","Deleted sucessfully !");
    }
}
