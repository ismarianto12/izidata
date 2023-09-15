<?php

namespace App\Http\Controllers;

use App\Models\post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IdentitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        //
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

    public function createSeoUrl($string)
    {
        $string = strtolower($string); // Convert to lowercase
        $string = preg_replace('/[^a-z0-9\-]/', '-', $string); // Replace non-alphanumeric characters with hyphens
        $string = preg_replace('/-+/', '-', $string); // Replace multiple hyphens with a single hyphen
        $string = trim($string, '-'); // Trim hyphens from the beginning and end
        return $string;
    }

    public function store(Request $request)
    {
        try {

            $date = Carbon::now()->format('y-m-d h:i:s');

            $gambar = $this->request->file('picture');
            $fileNameBayar = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/files/', $fileNameBayar);

            $insert = new post;
            $insert->id_post = $this->request->id_post;
            $insert->id_category = $this->request->id_category;
            $insert->stockcode = $this->request->stockcode ? $this->request->stockcode : '0';
            $insert->title = $this->request->title ? $this->request->title : $this->request->headline;
            $insert->content = $this->request->content;
            $insert->seotitle = $this->createSeoUrl($this->request->headline);
            $insert->tags = $this->request->tags;
            $insert->tag = $this->request->tags;
            $insert->date = date('Y-m-d H:i:s');
            $insert->time = date('H:i:s');
            $insert->editor = $this->request->editor ? $this->request->editor : 0;
            $insert->active = 'Y';
            $insert->headline = 'Y';
            $insert->picture = $fileNameBayar;
            $insert->hits = 1;
            $insert->new_version = $this->request->new_version;
            $insert->save();

            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di tambahkan',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('gambar');
            $fileNameBayar = 'sptpd_' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path() . '/asset/esptpd/' . $date, $fileNameBayar);
            $insert = post::find($id);
            $insert->id_post = $this->requeset->id_post;
            $insert->id_category = $this->requeset->id_category;
            $insert->stockcode = $this->requeset->stockcode;
            $insert->title = $this->requeset->title;
            $insert->content = $this->requeset->content;
            $insert->seotitle = $this->requeset->seotitle;
            $insert->tags = $this->requeset->tags;
            $insert->tag = $this->requeset->tag;
            $insert->date = $this->requeset->date;
            $insert->time = $this->requeset->time;
            $insert->editor = $this->requeset->editor;
            $insert->protect = $this->requeset->protect;
            $insert->active = $this->requeset->active;
            $insert->headline = $this->requeset->headline;
            $insert->picture = $fileNameBayar;
            $insert->hits = $this->requeset->hits;
            $insert->new_version = $this->requeset->new_version;
            $insert->save();
            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di tambahkan',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            post::delete($id);
            return response()->json(['messages' => 'data berhasil dihapus']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
