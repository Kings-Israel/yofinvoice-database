<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\ProgramUIResource;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query('q');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Program::with('programType', 'bank', 'programCode')
            ->orderBy($sortBy, $orderBy);

        if (!is_null($searchQuery)) {
            $query->search('%' . $searchQuery . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $programs = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        foreach ($programs as $program) {
            $program['anchor'] = $program->getAnchor();
            $program['vendors'] = $program->getVendors();
        }

        $response = [
            'data' => ProgramUIResource::collection($programs),
            'total' => $programs->total(),
            'currentPage' => $programs->currentPage(),
            'lastPage' => $programs->lastPage(),
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        //
    }
}
