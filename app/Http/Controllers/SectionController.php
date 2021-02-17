<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\SectionDestroyRequest;
use App\Http\Requests\Section\SectionIndexRequest;
use App\Http\Requests\Section\SectionShowRequest;
use App\Http\Requests\Section\SectionStoreRequest;
use App\Http\Requests\Section\SectionUpdateRequest;
use App\Http\Resources\SectionResource;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SectionIndexRequest $request)
    {
        $authenticatedUser = Auth::user();
        $authenticatedTeacher = $authenticatedUser->profile;
        $sections = $authenticatedTeacher->sections;

        return SectionResource::collection($sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionStoreRequest $request)
    {
        $authenticatedUser = Auth::user();
        $authenticatedTeacher = $authenticatedUser->profile;

        $section = Section::create(array_merge(
            $request->validated(),
            ['teacher_id' => $authenticatedTeacher->id]
        ));

        return new SectionResource($section);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $section
     * @return \Illuminate\Http\Response
     */
    public function show(SectionShowRequest $request, int $section)
    {
        $section = Section::findOrFail($section);

        return new SectionResource($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, int $section)
    {
        $section = Section::findOrFail($section);
        $section->update($request->validated());

        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionDestroyRequest $request, int $section)
    {
        $section = Section::findOrFail($section);
        $section->delete();

        return response(null);
    }
}
