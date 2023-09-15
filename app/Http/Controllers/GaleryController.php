<?php

namespace App\Http\Controllers;

use App\Models\galery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GaleryController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $data = galery::get();
        return response()->json($data);
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
    public function store()
    {
        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('gambar');
            $filename = 'halaman_pages' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./galery/', $filename);

            $data = new galery();
            $data->deskripsiId = $this->request->deskripsiId;
            $data->deskripsiEn = $this->request->deskripsiEn;
            $data->id_album = $this->request->id_album;
            $data->title = $this->request->title;
            $data->gambar = $filename;
            $data->save();
            return response()->json([
                'status' => 'ok', 'messages' => 'data galery data berhasil di tambahkan',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ]);
        }

    }

    public function show(galery $galery)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function edit(galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('gambar');
            $filename = 'halaman_pages' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./galery/', $filename);
            $data = galery::find($id);
            $data->deskripsiId = $this->request->deskripsiId;
            $data->deskripsiEn = $this->request->deskripsiEn;
            $data->id_album = $this->request->id_album;
            $data->title = $this->request->title;
            $data->gambar = $filename;
            $data->save();
            return response()->json([
                'status' => 'ok', 'messages' => 'data galery data berhasil di tambahkan',
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
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(galery $galery)
    {

        try {

        } catch (\Throwable $th) {

        }
    }
}
