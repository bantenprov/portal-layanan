<?php

namespace Bantenprov\Layanan\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\LayananFacade;

/* Models */
use Bantenprov\Layanan\Models\Bantenprov\Layanan\Layanan;
use Bantenprov\GroupEgovernment\Models\Bantenprov\GroupEgovernment\GroupEgovernment;
use Bantenprov\SectorEgovernment\Models\Bantenprov\SectorEgovernment\SectorEgovernment;
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
    protected $group_egovernmentModel;
    protected $sector_egovernment;
    protected $layanan;
    protected $user;

    public function __construct(Layanan $layanan, GroupEgovernment $group_egovernment, User $user, SectorEgovernment $sector_egovernment)
    {
        $this->layanan      = $layanan;
        $this->group_egovernmentModel    = $group_egovernment;
        $this->sector_egovernment    = $sector_egovernment;
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
        $response = $query->with('user')->with('group_egovernment')->with('sector_egovernment')->paginate($perPage);

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
        $group_egovernment = $this->group_egovernmentModel->all();
        $sector_egovernment = $this->sector_egovernment->all();
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['group_egovernment'] = $group_egovernment;
        $response['sector_egovernment'] = $sector_egovernment;
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
            'group_egovernment_id' => 'required',
            'sector_egovernment_id' => 'required',
            'user_id' => 'required',
            'label' => 'required',
            'description' => 'required',
            'link' => 'required'
        ]);

        if($validator->fails()){
            $check = $layanan->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $layanan->group_egovernment_id = $request->input('group_egovernment_id');
                $layanan->sector_egovernment_id = $request->input('sector_egovernment_id');
                $layanan->user_id = $request->input('user_id');
                $layanan->label = $request->input('label');
                $layanan->description = $request->input('description');
                $layanan->link = $request->input('link');
                $layanan->save();

                $response['message'] = 'success';
            }
        } else {
            $layanan->group_egovernment_id = $request->input('group_egovernment_id');
            $layanan->sector_egovernment_id = $request->input('sector_egovernment_id');
            $layanan->user_id = $request->input('user_id');
            $layanan->label = $request->input('label');
            $layanan->description = $request->input('description');
            $layanan->link = $request->input('link');
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
        $response['group_egovernment'] = $layanan->group_egovernment;
        $response['sector_egovernment'] = $layanan->sector_egovernment;
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
        $response['group_egovernment'] = $layanan->group_egovernment;
        $response['sector_egovernment'] = $layanan->sector_egovernment;
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
        $response = array();
        $message  = array();

        $layanan = $this->layanan->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'label' => 'required',
                'description' => 'required',
                'group_egovernment_id' => 'required',
                'sector_egovernment_id' => 'required',
                'user_id' => 'required',
                'link' => 'required'
            ]);
            
        if($validator->fails()){

                foreach($validator->messages()->getMessages() as $key => $error){
                    foreach($error AS $error_get) {
                        array_push($message, $error_get. "\n");
                    }                
                } 
                $response['message'] = $message;
        } else {
            $layanan->label = $request->input('label');
            $layanan->description = $request->input('description');
            $layanan->group_egovernment_id = $request->input('group_egovernment_id');
            $layanan->sector_egovernment_id = $request->input('sector_egovernment_id');
            $layanan->user_id = $request->input('user_id');
            $layanan->link = $request->input('link');
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
