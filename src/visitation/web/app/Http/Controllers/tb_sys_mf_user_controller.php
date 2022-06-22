<?php
namespace App\Http\Controllers;

use App\Http\Requests\tb_sys_mf_user_validation;
use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_approval_hierarchy_type;
use App\Models\tb_sys_mf_user;
use App\Models\tb_sys_mf_user_access_type;
use App\Models\tb_sys_mf_user_approval_hierarchy_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class tb_sys_mf_user_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('route_users');
        $name = $request['name'];
        $users = tb_sys_mf_user::when(isset($name), function ($q) use ($name){
                                return $q->where('tb_sys_mf_user.name', 'like', '%'.$name.'%');})
                                ->sortable(['id', 'name', 'email'])
                                ->paginate(env('ROW_COUNT'));
        return view('tb_sys_mf_user.index', ['users' => $users]);
    }

    public function create()
    {
        $this->authorize('route_users');
        $detail_access_types_dd = tb_sys_mf_access_type::all();
        $detail_apr_type_dd = tb_sys_mf_approval_hierarchy_type::all();
        return view('tb_sys_mf_user.create', ['detail_access_types_dd' => $detail_access_types_dd, 'detail_apr_type_dd' => $detail_apr_type_dd]);
    }

    public function store(tb_sys_mf_user_validation $request)
    {
        $this->authorize('route_users');
        if ($request->password === $request->confirm_password)
        {
            $validatedData = $request->validated();
            if (isset($request->image))
            {
                $new_image_name = time() . '-' . str_replace(' ', '-', $request->name) . '.' . $request
                    ->image
                    ->extension();
                $request
                    ->image
                    ->move(public_path('images\profiles') , $new_image_name);
                $validatedData['image_path'] = $new_image_name;
            }
            $detail_access_types = ($request['detail_access_type_id'] ?? []);
            $detail_apr_types = ($request['detail_approval_type_id'] ?? []);
            $remove = ['detail_access_type_id', 'detail_approval_type_id', 'image'];
            $validatedData = array_diff_key($validatedData, array_flip($remove));
            $user = new tb_sys_mf_user();
            $user->fill($validatedData);
            $user->password = Hash::make($validatedData['password']);
            $user->save();
            // Create User Access
            if (count($detail_access_types) > 0)
            {
                foreach ($detail_access_types as $key => $detail_access_type)
                {
                    $data2 = array(
                        'user_id' => $user->id,
                        'access_type_id' => $detail_access_types[$key],
                        'created_at' => Carbon::now('UTC') ,
                        'updated_at' => Carbon::now('UTC')
                    );
                    tb_sys_mf_user_access_type::insert($data2);
                }
            }
            // Create User Approval
            if (count($detail_apr_types) > 0)
            {
                foreach ($detail_apr_types as $key => $detail_apr_type)
                {
                    $data3 = array(
                        'user_id' => $user->id,
                        'approval_type_id' => $detail_apr_types[$key],
                        'created_at' => Carbon::now('UTC') ,
                        'updated_at' => Carbon::now('UTC')
                    );
                    tb_sys_mf_user_approval_hierarchy_type::insert($data3);
                }
            }
            $request->session()
                ->flash('status', 'User was created!');
            return redirect()
                ->route('users.index');
        }
        else
        {
            $request->session()
                ->flash('alert', 'Passwords does not match!');
            return back();
        }
    }
    public function show($id)
    {
        $this->authorize('route_users');
        $user = tb_sys_mf_user::findOrFail($id);
        $detail_access_types_dd = tb_sys_mf_access_type::all();
        $user_access_types = tb_sys_mf_user_access_type::where('user_id', $id)->get();
        $detail_apr_type_dd = tb_sys_mf_approval_hierarchy_type::all();
        $user_apr_types = tb_sys_mf_user_approval_hierarchy_type::where('user_id', $id)->get();
        return view('tb_sys_mf_user.show', ['user' => $user, 'detail_access_types_dd' => $detail_access_types_dd, 'user_access_types' => $user_access_types, 'detail_apr_type_dd' => $detail_apr_type_dd, 'user_apr_types' => $user_apr_types]);
    }

    public function edit(Request $request, $id)
    {
        $user = tb_sys_mf_user::findOrFail($id);
        $this->authorize('update', $user);
        $detail_access_types_dd = tb_sys_mf_access_type::all();
        $user_access_types = tb_sys_mf_user_access_type::where('user_id', $id)->get();
        $detail_apr_type_dd = tb_sys_mf_approval_hierarchy_type::all();
        $user_apr_types = tb_sys_mf_user_approval_hierarchy_type::where('user_id', $id)->get();
        return view('tb_sys_mf_user.edit', ['user' => $user, 'detail_access_types_dd' => $detail_access_types_dd, 'user_access_types' => $user_access_types, 'detail_apr_type_dd' => $detail_apr_type_dd, 'user_apr_types' => $user_apr_types]);
    }
    public function update(Request $request, $id)
    {
        $user = tb_sys_mf_user::findOrFail($id);
        $this->authorize('update', $user);
        $validated = $request->validate(['name' => 'required', 'email' => 'required|email', 'image' => 'nullable|mimes:jpg,png,jpeg|max:5048', 'detail_access_type_id.*' => 'nullable', 'detail_user_access_type_id.*' => 'nullable', 'detail_approval_type_id' => 'nullable', 'detail_user_approval_type_id' => 'nullable', 'is_admin' => 'nullable', 'is_active' => 'nullable',

        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $validated['is_admin'];
        $user->is_active = $validated['is_active'];

        if (isset($request->image))
        {
            if($user->image_path != 'default.png'){
                if (file_exists('images/profiles/' . $user->image_path)) {
                    unlink('images/profiles/' . $user->image_path);
                }
            }
            $new_image_name = time() . '-' . str_replace(' ', '-', $validated['name']) . '.' . $request
                ->image
                ->extension();
            $request
                ->image
                ->move(public_path('images\profiles') , $new_image_name);
            $user->image_path = $new_image_name;

        }

        $detail_access_types = ($validated['detail_access_type_id'] ?? []);
        $detail_user_access_types = ($validated['detail_user_access_type_id'] ?? []);

        $detail_approval_types = ($request['detail_approval_type_id'] ?? []);
        $detail_user_approval_types = ($request['detail_user_approval_type_id'] ?? []);

        if (count($detail_user_access_types) == 0)
        {
            $not = DB::table('tb_sys_mf_user_access_type')->select('id')
                ->where('user_id', $user->id)
                ->get();
            foreach ($not as $n)
            {
                $remove_data = DB::table('tb_sys_mf_user_access_type')->where('id', $n->id)
                    ->delete();
            }
        }
        else
        { // Delete Removed Child
            $not = DB::table('tb_sys_mf_user_access_type')->select('id')
                ->where('user_id', $user->id)
                ->whereNotIn('id', $detail_user_access_types)->get();
            if (count($not) > 0)
            {
                foreach ($not as $n)
                {
                    $remove_data = DB::table('tb_sys_mf_user_access_type')->where('id', $n->id)
                        ->delete();
                }
            }
        }

        if (count($detail_user_approval_types) == 0)
        {
            $not = DB::table('tb_sys_mf_user_approval_hierarchy_type')->select('id')
                ->where('user_id', $user->id)
                ->get();
            foreach ($not as $n)
            {
                $remove_data = DB::table('tb_sys_mf_user_approval_hierarchy_type')->where('id', $n->id)
                    ->delete();
            }
        }
        else
        { // Delete Removed Child
            $not = DB::table('tb_sys_mf_user_approval_hierarchy_type')->select('id')
                ->where('user_id', $user->id)
                ->whereNotIn('id', $detail_user_approval_types)->get();
            if (count($not) > 0)
            {
                foreach ($not as $n)
                {
                    $remove_data = DB::table('tb_sys_mf_user_approval_hierarchy_type')->where('id', $n->id)
                        ->delete();
                }
            }
        }
        // Update/Create Child
        if (count($detail_access_types) > 0)
        {
            foreach ($detail_access_types as $key => $detail_access_type)
            {
                if (isset($detail_user_access_types[$key]))
                {
                    $update = DB::table('tb_sys_mf_user_access_type')->where('id', $detail_user_access_types[$key])->update(['access_type_id' => $detail_access_types[$key], 'updated_at' => Carbon::now('UTC') ]);
                }
                else
                {
                    $create = DB::table('tb_sys_mf_user_access_type')->insert(['user_id' => $user->id, 'access_type_id' => $detail_access_types[$key], 'created_at' => Carbon::now('UTC') , 'updated_at' => Carbon::now('UTC') ]);
                }
            }
        }
        // Update/Create Child
        if (count($detail_approval_types) > 0)
        {
            foreach ($detail_approval_types as $key => $detail_apr_type)
            {
                if (isset($detail_user_approval_types[$key]))
                {
                    $update = DB::table('tb_sys_mf_user_approval_hierarchy_type')->where('id', $detail_user_approval_types[$key])->update(['approval_type_id' => $detail_approval_types[$key], 'updated_at' => Carbon::now('UTC') ]);
                }
                else
                {
                    $create = DB::table('tb_sys_mf_user_approval_hierarchy_type')->insert(['user_id' => $user->id, 'approval_type_id' => $detail_approval_types[$key], 'created_at' => Carbon::now('UTC') , 'updated_at' => Carbon::now('UTC') ]);
                }
            }
        }
        $user->update();
        $request->session()
            ->flash('status', 'User was updated!');
        return redirect()
            ->route('users.edit', ['user' => $user]);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('route_users');
        $user = tb_sys_mf_user::findOrFail($id);
        $this->authorize('delete', $user); // return 403 if user is attempting to delete itself
        $user->delete();
        $request->session()
            ->flash('status', 'User was deleted!');
        return redirect()
            ->route('users.index');
    }

    public function edit_password($id)
    {
        $user = tb_sys_mf_user::findOrFail($id);
        $this->authorize('update', $user);
        return view('tb_sys_mf_user.edit_pw', ['user' => $user]);
    }

    public function update_password(Request $request, $id)
    {
        $user = tb_sys_mf_user::findOrFail($id);
        $this->authorize('update', $user);
        $request->validate(['new_password' => 'required', 'conf_new_password' => 'required']);
        $new_password = Hash::make($request->new_password);
        if (Hash::check($request->conf_new_password, $new_password))
        {
            $user->password = $new_password;
            $user->update();
            $request->session()
                ->flash('status', "User's password was updated!");
            return redirect()
                ->route('users.edit-pw', ['user' => $user]);
        }
        else
        {
            $request->session()
                ->flash('alert', 'Confirm Password does not match!');
            return back();
        }
    }

    public function select_user(Request $request)
    {
        $this->authorize('route_users');
    	$search = $request->search;
        if($search == ''){
            $results = tb_sys_mf_user::select('id', 'name')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        }else{
            $results = tb_sys_mf_user::select('id', 'name')
            ->where('name', 'like', '%'.$search.'%')
            ->orderBy('name', 'asc')
            ->get();
        }
        $response = array();
        foreach($results as $result){
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }
        echo json_encode($response);
    }

}
    
