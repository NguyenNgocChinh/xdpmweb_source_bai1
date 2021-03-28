<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $page_size = 5;

    public function __construct(Request $request)
    {
        if ($request->page_size)
            $this->page_size = $request->page_size;
    }

    //Lấy danh sách tất cả các user
    public function listUser(Request $request){
        $users = User::paginate($this->page_size);
        if ($users)
            return response()->json($users);
        abort(404, "ERROR SERVER CANNOT GET LIST USER");
    }

    //Lấy user theo id
    public function findUserByID($id){
        return response()->json(User::findOrFail($id));
    }



    //Thêm (lưu mới) 1 user
    public function createUser(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'password' => 'required|min:4|confirmed',
                'phone' => 'required:min:10',
                'email' => 'required|email|unique:users,email'
            ]
        );
       $user = new User();
       $user->fill($request->all());
       $user->save();
       return response()->json(
           [
               'success' => 'success',
               'user' => $user
           ]
       );
    }
    //Sửa (cập nhật vào db) 1 user.
    public function updateUser(Request $request){
        $request->validate(
            [
                'id' => 'required',
                'name' => 'required',
                'password' => 'required|min:4|confirmed',
                'phone' => 'required:min:10',
                'email' => 'required|email|unique:users,email,' . $request->id
            ]
        );
        $user = User::find($request->id);
        if (!$user)
            return response()->json(
                ['error' => 'User không tồn tại!']
            );

        $user->fill($request->all());
        $user->update();
        return response()->json(
            [
                'success' => 'success',
                'user' => $user
            ]
        );
    }

    //Tìm kiếm user theo tên
    public function findUserByName($name){
        $user = User::where('name',$name)->paginate($this->page_size);

        return response()->json($user);
    }

    //Xóa user theo id
    public function deleteUser($id){

        $user = User::find($id);
        if (!$user)
            return response()->json(
                ['error' => 'User không tồn tại!']
            );
        $status = $user->delete();

        return response()->json(
            [
                'success' => $status
            ]
        );
    }
}
