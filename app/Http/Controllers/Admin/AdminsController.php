<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class AdminsController extends Controller
{
    protected $viewPath = 'Admin.admins';
    private $route = 'admins';

    public function __construct(Admin $model)
    {
        $this->objectName = $model;
    }

    public function index()
    {
        return view($this->viewPath . '.index');
    }


    public function datatable(Request $request)
    {
        $data = $this->objectName::orderBy('id', 'desc');
        return DataTables::of($data)
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
//            ->addColumn('status', $this->viewPath . '.parts.active_btn')
            ->addColumn('actions', function ($row) {
                $actions = ' <a href="' . url($this->route . "/edit/" . $row->id) . '" class="btn btn-active-light-info">' . trans('lang.edit') . '<i class="bi bi-pencil-fill"></i>  </a>';
                return $actions;

            })
            ->rawColumns(['actions', 'checkbox'])
            ->make();

    }

    public function table_buttons()
    {
        $permissions = Permission::get();
        return view($this->viewPath . '.button',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view($this->viewPath . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(AdminRequest $request)
    {
        $data = $request->validated();

        $result = $this->objectName::create($data);
//        createLog($result, 1, $this->route, "#", $result->name);
        $result->givePermissionTo($request->permissions);

        return redirect(route($this->route . '.index'))->with('message', trans('lang.added_s'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $permissions = Permission::get();
        $data = $this->objectName::findOrFail($id);
        return view($this->viewPath . '.edit', compact('data','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AdminRequest $request)
    {
        $edit = $this->objectName::find($request->id);

        $data = $request->validated();

        $result = $this->objectName::whereId($request->id)->first();
        $result->update($data);

//        editLog($result, 1, $this->route, "#", $result->name);
        $result->syncPermissions($request->permissions);
        return redirect(route($this->route . '.index'))->with('message', trans('lang.updated_s'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $results = $this->objectName::whereIn('id', $request->id)->get();
            foreach ($results as $key => $result) {
                delLog($result, 1, $this->route, $result->name);
            }

            $this->objectName::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

    public function changeActive(Request $request)
    {
        $data['status'] = $request->status;
        $this->objectName::where('id', $request->id)->update($data);
        return 1;
    }

    public function Setting()
    {
        $data = Admin::findOrFail(Auth::guard('admin')->id());
        return view('Admin.admins.Profile', compact('data'));
    }

    public function UpdateProfile(AdminRequest $request){

        $data = $request->validated();
        $result = Admin::whereId(Auth::guard('admin')->id())->first();
        $result->update($data);

        editLog($result, 1, 'admins', "#", $result->name);

        return back()->with('message', trans('lang.updated_s'));
    }
}
