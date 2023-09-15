<?php
namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json(['api' => 'v1']);
    }
    public function artikel()
    {
        $data = post::get();
        return response()->json($data);
    }

    private function removeCharacter($parmater)
    {
        $paramater = str_replace($parmater, ' ', '-');
        $data = ucfirst($paramater);
        return $data;
    }

    private function filterPenghargaan($perPage, $tahun, $limit)
    {
        $query = DB::table('penghargaan')
            ->select('id', 'namapenghargaan', 'kategori', 'diberikanoleh', 'lokasi', 'tahun', 'file', 'updated_at', 'user_id');

        if ($tahun) {
            $query->whereYear('tahun', $tahun);
        }

        if ($limit) {
            $query->limit($limit);
        }

        $penghargaan = $query->paginate($perPage);
        return response()->json($penghargaan);
    }

    public function penghargaan(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $tahun = $request->input('tahun');
        $limit = $request->input('limit');

        $penghargaan = $this->filterPenghargaan($perPage, $tahun, $limit);

        return $penghargaan;
    }
    public function filterPosts(Request $request)
    {
        $perPage = $request->input('per_page', 9); // Default to 10 per page, change as needed
        $tahun = $request->input('tahun', ''); // Filter by tahun
        $limit = $request->input('limit', ''); // Limit the results
        $sort = $request->input('sort', 'desc');
        $query = DB::table('post')
            ->select('post.id_post', 'post.id_category', 'post.stockcode', 'post.title', 'post.judul', 'post.content', 'post.isi', 'post.seotitle', 'post.tags', 'post.tag', 'post.date', 'post.time', 'post.editor', 'post.protect', 'post.active', 'post.headline', 'post.picture', 'post.hits', 'post.new_version', 'category.title')
            ->join('category', 'post.title', '=', 'category.id_category', 'left')
            ->whereNotNull('post.title');
        if (!empty($tahun)) {
            $query->whereYear('post.date', $tahun);
        }
        if (!empty($sort)) {
            $query->orderBy('post.id_post', $sort);
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        $posts = $query->paginate($perPage);
        return response()->json($posts);
    }

    public function filterNewGalery(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'per_page' => 'integer|min:1|max:100',
                'year' => 'nullable|date_format:Y',
                'limit' => 'nullable|integer|min:1|max:100',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
        $perPage = $validatedData['per_page'] ?? 8;
        $tahun = $validatedData['year'] ?? '';
        $limit = $validatedData['limit'] ?? '';

        $query = DB::table('events')
            ->select(
                'events.title',
                'events.headline',
                'events.published',
                'events.active',
                'events.images',
                'events.images_desc'
            );

        if ($tahun != '') {
            $query->whereYear('events.created_at', $tahun);
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }

        $data = $query->paginate($perPage);
        return response()->json($data);
    }

    public function filterGalery(Request $request)
    {
        $perPage = $request->input('per_page', 8); // Default to 10 per page, change as needed
        $tahun = $request->input('year', ''); // Filter by tahun
        $limit = $request->input('limit', ''); // Limit the results
        $query = DB::table('galery')
            ->select(
                'galery.id',
                'galery.title',
                'galery.deskripsiId',
                'galery.deskripsiEn',
                'galery.id_album',
                'galery.gambar',
                'galery.created_at',
                'album.title AS album_title',
                'album.seotitle AS album_seotitle',
                'album.active AS album_active'
            )
            ->leftJoin('album', 'galery.id_album', '=', 'album.id_album'); // Left join with the album table

        if ($tahun != '') {
            $query->whereYear('galery.created_at', $tahun);
        }

        if (!empty($limit)) {
            $query->limit($limit);
        }

        $galeries = $query->paginate($perPage);
        return response()->json($galeries);
    }

    public function filterPostsBycat(Request $request)
    {
        $perPage = $request->input('per_page', 9); // Default to 10 per page, change as needed
        $category = $request->input('category', ''); // Filter by tahun
        $limit = $request->input('limit', ''); // Limit the results

        $query = DB::table('post')
            ->select('post.id_post', 'post.id_category', 'post.stockcode', 'post.title', 'post.judul', 'post.content', 'post.isi', 'post.seotitle', 'post.tags', 'post.tag', 'post.date', 'post.time', 'post.editor', 'post.protect', 'post.active', 'post.headline', 'post.picture', 'post.hits', 'post.new_version', 'category.title')
            ->join('category', 'post.id_category', '=', 'category.id_category', 'left')
            ->where('category.seotitle', $category)
            ->whereNotNull('post.title');
        if (!empty($tahun)) {
            $query->whereYear('post.date', $tahun);
        }

        if (!empty($limit)) {
            $query->limit($limit);
        }
        $posts = $query->paginate($perPage);
        return response()->json($posts);
    }

    public function searchPost(Request $request)
    {
        $perPage = $request->input('per_page', 9);
        $query = $request->input('q', '');
        $limit = $request->input('limit', '');
        $query = DB::table('post')
            ->select('post.id_post', 'post.id_category', 'post.stockcode', 'post.title', 'post.judul', 'post.content', 'post.isi', 'post.seotitle', 'post.tags', 'post.tag', 'post.date', 'post.time', 'post.editor', 'post.protect', 'post.active', 'post.headline', 'post.picture', 'post.hits', 'post.new_version', 'category.title')
            ->join('category', 'post.id_category', '=', 'category.id_category', 'left')
            ->like('category.seotitle', $query)
            ->whereNotNull('post.title');
        if (!empty($tahun)) {
            $query->whereYear('post.date', $tahun);
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        $posts = $query->paginate($perPage);
        return response()->json($posts);
    }

}
