<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DownloadController extends Controller
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

        $data = Download::get();
        return response()->json($data);

    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $date = Carbon::now()->format('Y-m-d');
            $gambar = $request->file('file');
            $filename = 'file_download' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./download/', $filename);

            $data = new Download();

            $data->judul = $request->input('judulin');
            $data->judulEng = $request->input('judulEn');
            $data->isi = $request->input('isi');
            $data->isiEng = $request->input('isiEng');
            $data->file = $filename;
            $data->category_donwload_id = 1;
            // $data->created_at = $date;
            // $data->updated_at = $date; // Note the correct column name here
            $data->save();

            return response()->json([
                'status' => 'ok',
                'messages' => 'data download berhasil di tambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'messages' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function show(Download $download)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Download::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('file');
            $filename = 'file_download' . rand() . '.' . $filename->getClientOriginalExtension();
            $gambar->move('./public/download/', $filename);

            $data = Download::find($id);
            $data->judul = $this->request->judulin;
            $data->judulEng = $this->request->judulEng;
            $data->isi = $this->request->isi;
            $data->isiEng = $this->request->isiEng;
            $data->file = $filename;
            $data->category_donwload_id = 1;
            $data->created_at = $date;
            $data->update_at = $date;
            $data->save();

            return response()->json([
                'status' => 'ok',
                'messages' => 'data download berhasil di tambahkan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'ok',
                'messages' => $th,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Download::find($id);
            // $file = $data->file;
            // @unlink('./public/download/', $file);
            $data->delete();
            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di hapus',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal hapus data',
                'errorcode' => 'error code' . $th,
            ], 500);
        }
    }
}
