<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\post;
use App\Models\Promosi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $data = Jadwal::get();
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
            $gambar = $this->request->file('gambar');
            $filename = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/', $filename);
            $data = new Jadwal;
            $data->topic = $this->request->topic;
            $data->descriptionId = $this->request->descriptionId;
            $data->descriptionEn = $this->request->descriptionEn;
            $data->type_edukasi = $this->request->type_edukasi;
            $data->link_registrasi = $this->request->link_registrasi;
            $data->image = $filename;
            $data->created_at = Carbon::now()->format('Y-m-d h:i:s');
            $data->updated_at = Carbon::now()->format('Y-m-d h:i:s');
            $data->user_id = $this->request->user_id;

            $data->save();

            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di tambahkan',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Promosi::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Jadwal::find($id);
            return response()->json($data);
        } catch (\App\Models\Jadwal $th) {
            return response()->json($th->getMessage());

        }
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
            $gambar = $this->request->file('gambar');
            $filename = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/', $filename);
            $jadwal = Jadwal::where('id', $id);
            $jadwal->update(
                [
                    'topic' => $this->request->topic,
                    'descriptionId' => $this->request->descriptionId,
                    'descriptionEn' => $this->request->descriptionEn,
                    'type_edukasi' => $this->request->type_edukasi,
                    'link_registrasi' => $this->request->link_registrasi,
                    'image' => $filename,
                    'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
                    'user_id' => $this->request->user_id,
                ]
            );
            return response()->json([
                'status' => 'ok', 'messages' => 'data berhasil di upadate',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ], 400);
        }

    }

    public function destroy($id)
    {
        try {
            Jadwal::where('id', $id)->delete($id);
            return response()->json(['messages' => 'data berhasil dihapus']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
