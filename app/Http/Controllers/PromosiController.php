<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\Promosi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromosiController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $data = Promosi::get();
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

            $date = Carbon::now()->format('y-m-d h:i:s');

            $gambar = $this->request->file('filethumnaild');
            $ffilethumnaild = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/filethumnaild', $ffilethumnaild);

            $gambar = $this->request->file('imagepopup');
            $fimagepopup = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/imagepopup', $fimagepopup);

            $gambar = $this->request->file('imageheader');
            $fimageheader = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/imageheader', $fimageheader);

            $gambar = $this->request->file('document1');
            $focument1 = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/document1', $focument1);

            $gambar = $this->request->file('document2');
            $fdocument2 = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/document2', $fdocument2);

            $data = new Promosi;
            $data->titleID = $this->request->titleID;
            $data->titleEn = $this->request->titleEn;
            $data->deskripsiId = $this->request->deskripsiId;
            $data->deskripsiEn = $this->request->deskripsiEn;
            $data->filethumnaild = $ffilethumnaild;
            $data->imagepopup = $fimagepopup;
            $data->imagepopup = $fimagepopup;
            $data->imageheader = $fimageheader;
            $data->document1 = $focument1;
            $data->document2 = $fdocument2;
            $data->linkvideo = $this->request->linkvideo;
            $data->created_at = $date; //Carbon::now()->format('Y-m-d h:i:s');
            $data->updated_at = $date; // Carbon::now()->format('Y-m-d h:i:s');
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
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('adsa');
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
        $data = Promosi::find($id);
        return response()->json($data);

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

            $gambar = $this->request->file('filethumnaild');
            $ffilethumnaild = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/filethumnaild', $ffilethumnaild);

            $gambar = $this->request->file('imagepopup');
            $fimagepopup = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/imagepopup', $fimagepopup);

            $gambar = $this->request->file('imageheader');
            $fimageheader = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/imageheader', $fimageheader);

            $gambar = $this->request->file('document1');
            $focument1 = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/document1', $focument1);

            $gambar = $this->request->file('document2');
            $fdocument2 = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./public/promosi/document2', $fdocument2);

            $data = Promosi::find($id);
            $data->titleID = $this->request->titleID;
            $data->titleEn = $this->request->titleEn;
            $data->deskripsiId = $this->request->deskripsiId;
            $data->deskripsiEn = $this->request->deskripsiEn;
            $data->filethumnaild = $ffilethumnaild;
            $data->imagepopup = $fimagepopup;
            $data->imagepopup = $fimagepopup;
            $data->imageheader = $fimageheader;
            $data->document1 = $focument1;
            $data->document2 = $fdocument2;
            $data->linkvideo = $this->request->linkvideo;
            $data->created_at = $date; //Carbon::now()->format('Y-m-d h:i:s');
            $data->updated_at = $date; // Carbon::now()->format('Y-m-d h:i:s');
            $data->user_id = $this->request->user_id;
            $data->save();

            return response()->json([
                'status' => 'ok', 'messages' => 'databerhasil di edit',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error event insert data',
                'errorcode' => 'error code' . $th,
            ]);
        }

    }

    public function destroy($id)
    {
        try {
            Promosi::where('id', $id)->delete($id);
            return response()->json(['messages' => 'data berhasil dihapus']);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json(['messages' => $th], 400);
        }
    }
}
