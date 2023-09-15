<?php

namespace App\Http\Controllers;

use App\Models\post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
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
            $filename = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('./files/', $filename);

            $insert = new post;
            $insert->stockcode = "";
            $insert->id_category = $this->request->id_category ? $this->request->id_category : '';
            $insert->title = $this->request->title ? $this->request->title : '';
            $insert->seotitle = $this->createSeoUrl($this->request->title);
            $insert->judul = $this->request->judul ? $this->request->judul : '';
            $insert->content = $this->request->content ? $this->request->content : '';
            $insert->isi = $this->request->isi ? $this->request->isi : '';
            $insert->tags = $this->request->tags ? $this->request->tags : '';
            $insert->tag = $this->request->tag ? $this->request->tag : '';
            $insert->protect = $this->request->protect ? $this->request->protect : '';
            $insert->picture = $filename;
            $insert->new_version = '1';
            $insert->date = $date;
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
    public function edit($id)
    {
        $data = post::where('id_post', $id)->first();
        return response()->json($data);
    }
    public function update($id)
    {
        try {
            $edit = post::where('id_post', $id);
            $date = Carbon::now()->format('y-m-d h:i:s');
            $gambar = $this->request->file('picture');
            if ($gambar != '') {
                if ($edit->count() > 0) {
                    @unlink('./file/' . $edit->get()->first()->picture);
                    $filename = 'artikel_file' . rand() . '.' . $gambar->getClientOriginalExtension();
                    $gambar->move('./files/', $filename);
                }
            } else {
                $filename = isset($edit->get()->first()->picture) ? $edit->get()->first()->picture : '';
            }
            $edit->update([
                'stockcode' => $this->request->stockcode ? $this->request->stockcode : '',
                'id_category' => $this->request->id_category ? $this->request->id_category : '',
                'title' => $this->request->title ? $this->request->title : '',
                'seotitle' => $this->createSeoUrl($this->request->title),
                'judul' => $this->request->judul ? $this->request->judul : '',
                'content' => $this->request->content ? $this->request->content : '',
                'isi' => $this->request->isi ? $this->request->isi : '',
                'tags' => $this->request->tags ? $this->request->tags : '',
                'tag' => $this->request->tag ? $this->request->tag : '',
                'protect' => $this->request->protect ? $this->request->protect : '',
                'picture' => $filename,
                'date' => $date,
            ]);
            return response()->json([
                'status' => 'ok', 'messages' => 'data berhasil diupdate',
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
            $get = post::where('id_post', $id);
            if ($get->count() > 0) {
                @unlink('./file/' . $get->first()->picture);
            }
            $get->delete($id);
            return response()->json(['messages' => 'data berhasil dihapus']);
        } catch (\post $th) {
            return response()->json(['messages' => $th]);

        }
    }
}
