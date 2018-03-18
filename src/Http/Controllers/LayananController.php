<?php

namespace Bantenprov\Layanan\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\LayananFacade;

/* Models */
use Bantenprov\Layanan\Models\Bantenprov\Layanan\Layanan;
use Bantenprov\Kegiatan\Models\Bantenprov\Kegiatan\Kegiatan;
use App\User;

/* Etc */
use Validator;

/**
 * The LayananController class.
 *
 * @package Bantenprov\Layanan
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class LayananController extends Controller
{  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $kegiatanModel;
    protected $layanan;
    protected $user;

    public function __construct(Layanan $layanan, Kegiatan $kegiatan, User $user)
    {
        $this->layanan      = $layanan;
        $this->kegiatanModel    = $kegiatan;
        $this->user             = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->layanan->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->layanan->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);

        foreach($response as $kegiatan){
            array_set($response->data, 'kegiatan', $kegiatan->kegiatan->label);
        }

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kegiatan = $this->kegiatanModel->all();
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['kegiatan'] = $kegiatan;
        $response['user'] = $users;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $layanan = $this->layanan;

        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required',
            'user_id' => 'required',
            'label' => 'required|max:16|unique:layanans,label',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            $check = $layanan->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $layanan->kegiatan_id = $request->input('kegiatan_id');
                $layanan->user_id = $request->input('user_id');
                $layanan->label = $request->input('label');
                $layanan->description = $request->input('description');
                $layanan->save();

                $response['message'] = 'success';
            }
        } else {
            $layanan->kegiatan_id = $request->input('kegiatan_id');
            $layanan->user_id = $request->input('user_id');
            $layanan->label = $request->input('label');
            $layanan->description = $request->input('description');
            $layanan->save();
            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $layanan = $this->layanan->findOrFail($id);

        $response['layanan'] = $layanan;
        $response['kegiatan'] = $layanan->kegiatan;
        $response['user'] = $layanan->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $layanan = $this->layanan->findOrFail($id);

        array_set($layanan->user, 'label', $layanan->user->name);

        $response['layanan'] = $layanan;
        $response['kegiatan'] = $layanan->kegiatan;
        $response['user'] = $layanan->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $layanan = $this->layanan->findOrFail($id);

        if ($request->input('old_label') == $request->input('label'))
        {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16',
                'description' => 'max:255',
                'kegiatan_id' => 'required',
                'user_id' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16|unique:layanans,label',
                'description' => 'max:255',
                'kegiatan_id' => 'required',
                'user_id' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $layanan->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $layanan->label = $request->input('label');
                $layanan->description = $request->input('description');
                $layanan->kegiatan_id = $request->input('kegiatan_id');
                $layanan->user_id = $request->input('user_id');
                $layanan->save();

                $response['message'] = 'success';
            }
        } else {
            $layanan->label = $request->input('label');
            $layanan->description = $request->input('description');
            $layanan->kegiatan_id = $request->input('kegiatan_id');
            $layanan->user_id = $request->input('user_id');
            $layanan->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Layanan  $layanan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $layanan = $this->layanan->findOrFail($id);

        if ($layanan->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
