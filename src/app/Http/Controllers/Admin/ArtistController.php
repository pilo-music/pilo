<?php

namespace App\Http\Controllers\Admin;

use App\Crawler\Tools\Helper;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Artist::query()->latest()->paginate(15);
        return view('admin.pages.artists.browser', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \view('admin.pages.artists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->has('image')) {
            $image = self::uploadFile($request->file('image'), 'artist', 'jpg');
        } else {
            $image = null;
        }

        $extra = [
            'image' => $image,
            'user_id' => auth()->user()->id,
            'slug'=> generate_slug($request->get('name'))
        ];

        $data = array_merge($request->all(), $extra);

        Artist::query()->create($data);

        flash(__('messages.operation_done'), 'success');

        return redirect()->route('artists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Artist $artist
     * @return View
     */
    public function edit(Artist $artist): View
    {
        return view('admin.pages.artists.edit', ['data' => $artist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Artist $artist
     * @return RedirectResponse
     */
    public function update(Request $request, Artist $artist)
    {
        if ($request->has('image')) {
            $image = self::uploadFile($request->file('image'), 'artist', 'jpg');
        } else {
            $image = $artist->image;
        }

        if ($request->has('image_null') && $request->image_null == 1) {
            $image = null;
            unset($request['image_null']);
        }


        $data = array_merge($request->all(), ['image' => $image]);

        $artist->update($data);

        flash(__('messages.operation_done'), 'success');

        return redirect()->route('artists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Artist  $artist)
    {
        $artist->delete();

        flash(__('messages.operation_done'), 'success');

        return redirect()->route('artists.index');
    }
}
