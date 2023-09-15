<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenghargaanController extends Controller
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
        $data = Penghargaan::get();
        return response()->json($data);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('file');
            $fileName = 'award' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./award/', $fileName);

            $data = new Penghargaan;
            $data->namapenghargaan = $this->request->namapenghargaan;
            $data->kategori = $this->request->kategori;
            $data->diberikanoleh = $this->request->diberikanoleh;
            $data->lokasi = $this->request->lokasi;
            $data->tahun = $this->request->tahun;
            $data->file = $fileName;
            $data->create_at = $this->request->create_at;
            $data->updated_at = $this->request->updated_at;
            $data->user_id = $this->request->user_id;
            $data->save();

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
     * @param  \App\Models\Penghargaan  $penghargaan
     * @return \Illuminate\Http\Response
     */
    public function show(Penghargaan $penghargaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penghargaan  $penghargaan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Penghargaan::find($id);
        return response()->json($data);
    }
    public function update($id)
    {
        try {
            $date = Carbon::now()->format('y-m-d h:i:s');
            if ($this->request->file('file') != '') {
                $data = Penghargaan::find($id);

                $gambar = $this->request->file('file');
                $fileName = 'award' . rand() . '.' . $gambar->getClientOriginalExtension();
                $gambar->move('./award/', $fileNameBayar);

                $data = Penghargaan::find($id);
                $data->namapenghargaan = $this->request->namapenghargaan;
                $data->kategori = $this->request->kategori;
                $data->diberikanoleh = $this->request->diberikanoleh;
                $data->lokasi = $this->request->lokasi;
                $data->tahun = $this->request->tahun;
                $data->file = $fileName;
                $data->create_at = $date;
                $data->updated_at = $date;
                $data->user_id = $this->request->user_id;
                $data->save();
            } else {
                $data = Penghargaan::find($id);
                $data->namapenghargaan = $this->request->namapenghargaan;
                $data->kategori = $this->request->kategori;
                $data->diberikanoleh = $this->request->diberikanoleh;
                $data->lokasi = $this->request->lokasi;
                $data->tahun = $this->request->tahun;
                $data->create_at = $date;
                $data->updated_at = $date;
                $data->user_id = $this->request->user_id;
                $data->save();
            }
            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di tambahkan',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Penghargaan::find($id);

            // $file = $data->file;
            // @unlink('./award/', $file);
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
