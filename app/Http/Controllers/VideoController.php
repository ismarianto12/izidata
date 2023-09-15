<?php

namespace App\Http\Controllers;

use App\Models\video;
use Illuminate\Http\Request;

class VideoController extends Controller
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
        $data = video::select(
            'id_video as id',
            'title',
            'date',
            'url',
            'desc',
            'link',
            'description',
            'headline'
        )->get();
        return response()->json($data);
    }

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
    public function store(Request $request)
    {
        try {
            $data = new video;
            $data->id_video = $this->request->id_video;
            $data->title = $this->request->title;
            $data->date = date('Y-m-d h:i:s');
            $data->url = $this->request->url;
            $data->desc = $this->request->desc;
            $data->link = $this->request->link;
            $data->description = $this->request->description;
            $data->headline = "Y";
            $data->save();
            return response()->json([
                'status' => 'ok',
                'messages' => 'data video berhasil di tambahkan',
            ]);
        } catch (\video $th) {
            return response()->json([
                'status' => 'ok',
                'messages' => $th,
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = video::where('id_video',$id)->first();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\video  $video
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = video::find($id);
        try {
            $data->id_video = $this->request->id_video;
            $data->title = $this->request->title;
            $data->date = date('Y-m-d h:i:s');
            $data->url = $this->request->url;
            $data->desc = $this->request->desc;
            $data->link = $this->request->link;
            $data->description = $this->request->description;
            $data->headline = "Y";
            $data->save();
            return response()->json([
                'status' => 'ok',
                'messages' => 'data video berhasil di tambahkan',
            ]);
        } catch (\video $th) {
            return response()->json([
                'status' => 'ok',
                'messages' => $th,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(video $video)
    {

        try {
            video::find($id)->delete();
            return response()->json([
                'status' => 'ok',
                'messages' => 'data video berhasil di tambahkan',
            ]);
        } catch (\video $th) {
            return response()->json([
                'status' => 'ok',
                'messages' => 'data video gagal di tambahkan',
            ]);

        }
    }
}
