<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\FilterStructure;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::orderByDesc('route_id')->get();
        return View('admin.route.routes',compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filters = FilterStructure::whereNotIn('filter_status', [0,-1])->get()->toArray();
        
        return View('admin.route.add_route',compact('filters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $routes = Route::all();
        foreach($routes as $r){
            if ($r->route_name == $request->route_name) {
                return back()->with('error', 'Route already exists !');
            }
        }

        $route_new = new Route;
        $route_new->route_name = $request->route_name;
        $route_new->route_des = $request->route_des;
        $route_new->route_status = 0;
        $route_new->save();
        $route = Route::find($route_new->route_id);

        foreach($request->filter_id as $k => $v){
            $route->filter_structure()->attach($v, 
                [
                    'detail_route_level'    =>      $k + 1,
                ]);
        }
        return back()->with('success', 'Added Route Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail_route = Route::find($id)->filter_structure;
        foreach ($detail_route as $key => $value) {
        
            $data[] = 
            [
                'filter_name'   =>  $value->filter_name,
                'route_level'   =>  $value->pivot->detail_route_level,  
            ]; 
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $route = Route::find($id);
        $filters = FilterStructure::whereNotIn('filter_status', [0,-1])->get()->toArray();

        foreach ($route->filter_structure as $key => $value) {
            $data[] =
            [
                'filter_id'     =>      $value->filter_id,
                'filter_name'   =>      $value->filter_name,
                'route_level'   =>      $value->pivot->detail_route_level,    
            ];
        }

        return View('admin.route.update_route', compact('route','data','filters'));
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
        $route = Route::find($id);
        $routes = Route::all();

        foreach($routes as $r){
            if (($route->route_name != $request->route_name) && ($r->route_name == $request->route_name)) {
                return back()->with('error','Route already exists !');
            }
        }
        $route->route_des = $request->route_des;
        $route->route_name = $request->route_name;
        $route->save();

        $route->filter_structure()->detach();

        foreach ($request->filter_id as $key => $value) {
            $route->filter_structure()->attach($value,
                [
                    'detail_route_level'    =>      $key + 1,
                ]);
        }

        return redirect('/admin/routes')->with('success', 'Updated Route Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$status)
    {
        $route = Route::find($id);
        $route->route_status = $status;
        $route->save();

        return back()->with('success','Updated Status Successfully !');
    }

    public function destroyStructure($id){
        Route::find($id)->filter_structure()->detach($_GET['filter_id']);
        return back()->with('success','Delete Structure Successfully!');
    }
}
