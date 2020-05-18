<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Incident;
use App\Category;

class IncidentController extends Controller
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
            'title' => 'All Incidents',
            'incidents' => Incident::with('User')->with('Category')->paginate(10),
        ];

        return view('incident.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'New Incident Information',
            'user' => Auth::user(),
        ];

        return view('incident.create')->with($data);
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
            'category' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);

        // insert new incident
        $incident = new Incident;
        $incident->user_id = $request->user()->id;
        $incident->category_id = $request->input('category');
        $incident->date = $request->input('date');
        $incident->description = $request->input('description');
        $incident->save();

        $data = [
            'id' => Incident::where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')->get()->first()->id,
            'category' => $request->input('category'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
        ];

        return redirect()->route('incident.create')->with($data);
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
            'title' => 'Incident ID ' . $id,
            'id' => $id,
            'incident' => Incident::with('User')->with('Category')->find($id),
        ];

        return view('incident.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $incident = Incident::find($id);

        $data = [
            'title' => 'Update Incident',
            'incident' => $incident,
        ];

        return view('incident.edit')->with($data);
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
        // update incident
        $incident = Incident::find($id);
        $incident->category_id = $request->input('category');
        $incident->date = $request->input('date');
        $incident->description = $request->input('description');
        $incident->save();

        $data = [
            'title' => 'Incident ID ' . $id,
            'id' => $id,
            'incident' => $incident,
        ];

        return view('incident.show', [$id])->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Incident::destroy($id);

        return redirect()->route('incident.index');
    }

    /**
     * Show the form for searching incident.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $data = [
            'title' => 'Search Incidents',
        ];

        return view('incident.search')->with($data);
    }

    /**
     * Query incidents with specific attributes and keyword
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $date = $request->input('date');

        $results = new Incident;

        if ($keyword) $results = $results->where('description', 'like', '%' . $keyword . '%');
        if ($category) $results = $results->where('category_id', $category);
        if ($date) $results = $results->where('date', $date);

        $results = $results->orderBy('date', 'DESC');

        $data = [
            'search_title' => 'Search Results',
            'results' => $results->get(),
            'keyword' => $request->input('keyword'),
            'category' => $request->input('category'),
            'date' => $request->input('date'),
        ];

        return redirect()->route('incident.search')->with($data);
    }

    /**
     * Report on incidents by category count
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $cats = Category::all();
        $totalCount = 0;

        // add count to funcs
        foreach ($cats as $cat) {
            $cat['count'] = Category::find($cat['id'])->incidents->where('user_id', Auth::user()->id)->count();
            $totalCount += $cat['count'];
        }

        $data = [
            'title' => 'Incidents Report',
            'reports' => $cats,
            'total' => $totalCount,
        ];

        return view('incident.report')->with($data);
    }

    /**
     * Display a json listing of the incident.
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function list()
    {
        return Incident::with('user')->with('category')->get();
    }

    /**
     * Display a json listing of a specific incident.
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function list_one($id)
    {
        return Incident::with('user')->with('category')->find($id);
    }
}
