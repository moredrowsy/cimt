<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Resource;
use App\Capability;
use App\Func;

class ResourceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'user.view'], ['except' => ['list', 'list_one']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'All Resources',
            'resources' => Resource::with('User')->with('Pri_Func')->with('Sec_Func')->paginate(10),
        ];

        return view('resource.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'New Resource Information',
            'user' => Auth::user(),
        ];

        return view('resource.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'resource-name' => 'required',
            'primary-function' => 'required',
            'cost' => 'required',
        ]);

        // insert new resource
        $resource = new Resource;
        $resource->name = $request->input('resource-name');
        $resource->user_id = $request->user()->id;
        $resource->pri_func_id = $request->input('primary-function');
        $resource->sec_func_id = $request->input('secondary-function');
        $resource->description = $request->input('description');
        $resource->distance = $request->input('distance');
        $resource->cost = $request->input('cost');
        $resource->unit_cost_id = $request->input('unit-cost');
        $resource->save();

        // insert new capabilities
        $capabilities = $request->input('capabilities');
        $caps = [];

        if ($capabilities) {
            foreach ($capabilities as $cap)
                array_push($caps, new Capability(['name' => $cap,]));
            $resource->capabilities()->saveMany($caps);
        }

        $data = [
            'id' => Resource::where('user_id', $request->user()->id)->latest()->first()->id,
            'resource_name' => $request->input('resource-name'),
            'primary_function' => $request->input('primary-function'),
            'secondary_function' => $request->input('secondary-function'),
            'description' => $request->input('description'),
            'capabilities' => $capabilities,
            'distance' => $request->input('distance'),
            'cost' => $request->input('cost'),
            'unit_cost' => $request->input('unit-cost'),
        ];

        return redirect()->route('resource.create')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'title' => 'Resource ID' . $id,
            'id' => $id,
            'resource' => Resource::with('User')->with('Pri_Func')->with('Sec_Func')
                ->with('Capabilities')->with('Unit_Cost')->find($id),
        ];

        return view('resource.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = Resource::find($id);

        $data = [
            'title' => 'Update Resource',
            'resource' => $resource,
        ];

        return view('resource.edit')->with($data);
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
        // update resource
        $resource = Resource::find($id);
        $resource->name = $request->input('resource-name');
        $resource->pri_func_id = $request->input('primary-function');
        $resource->sec_func_id = $request->input('secondary-function');
        $resource->description = $request->input('description');
        $resource->distance = $request->input('distance');
        $resource->cost = $request->input('cost');
        $resource->unit_cost_id = $request->input('unit-cost');
        $resource->save();

        // get input capabilities
        $capabilities = $request->input('capabilities');

        if ($capabilities) {
            // find resource capabilities
            $cap_results = Capability::where('resource_id', $id)->get();

            // update capabilities
            $i = 0;
            while ($i < count($capabilities) && $i < count($cap_results)) {
                $cap_results[$i]->name = $capabilities[$i];
                $cap_results[$i]->save();
                ++$i;
            }

            // delete leftover old capabilities
            while ($i < count($cap_results)) {
                $cap_results[$i]->delete();
                ++$i;
            }

            // insert leftover new capabilities
            while ($i < count($capabilities)) {
                Capability::create([
                    'name' => $capabilities[$i],
                    'resource_id' => $id,
                ]);
                ++$i;
            }
        } else
            $resource->capabilities()->delete();

        $data = [
            'title' => 'Resource ID' . $id,
            'id' => $id,
            'resource' => $resource
        ];

        return view('resource.show', [$id])->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Resource::destroy($id);

        return redirect()->route('resource.index');
    }

    /**
     * Show the form for searching resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $data = [
            'title' => 'Search Resources',
        ];

        return view('resource.search')->with($data);
    }

    /**
     * Query resources with specific attributes and keyword
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {
        $keyword = $request->input('keyword');
        $pri_func = $request->input('primary-function');
        $incident = $request->input('incident');
        $distance = $request->input('distance');

        $results = new Resource;

        // AND search for primary function id and distance
        if ($pri_func) $results = $results->where('pri_func_id', $pri_func);
        if ($distance) $results = $results->whereNotNull('distance')
            ->where('distance', '<=', $distance);

        // AND search keyword for primary name
        // OR search for names or description or capabilities
        if ($keyword) {
            // query primary functions for HasMany relationship
            $results = $results->whereHas('pri_func', function (Builder $query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });

            // query resource name attribute
            $results = $results->orWhere('name', 'like', '%' . $keyword . '%');

            // query description attribute
            $results = $results->orWhere('description', 'like', '%' . $keyword . '%');

            // query capabilities for HasMany relationship
            $results = $results->orWhereHas('capabilities', function (Builder $query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
        }

        // sort by ascending distance
        $results = $results->orderByRaw('ISNULL(distance), distance ASC')->get();

        $data = [
            'search_title' => 'Search Results',
            'results' => $results,
            'keyword' => $request->input('keyword'),
            'primary_function' => $request->input('primary-function'),
            'incident' => $request->input('incident'),
            'distance' => $request->input('distance'),
        ];

        return redirect()->route('resource.search')->with($data);
    }

    /**
     * Report resources by primary function
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $funcs = Func::all();
        $totalCount = 0;

        // add count to funcs
        foreach ($funcs as $func) {
            $func['count'] = Func::find($func['id'])->resources_pri->where('user_id', Auth::user()->id)->count();
            $totalCount += $func['count'];
        }

        $data = [
            'title' => 'Resources Report',
            'reports' => $funcs,
            'total' => $totalCount,
        ];

        return view('resource.report')->with($data);
    }

    /**
     * Display a json listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function list()
    {
        return Resource::with('user')->with('pri_func')->with('sec_func')->with('capabilities')->get();
    }

    /**
     * Display a json listing of a specific resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function list_one($id)
    {
        return Resource::with('user')->with('pri_func')->with('sec_func')->with('capabilities')->find($id);
    }
}
