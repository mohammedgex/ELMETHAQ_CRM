<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    //
    public function permissions($id)
    {
        # code...
        $user = User::find($id);
        $userPermissions = $user->permissions->pluck('permission')->toArray();


        return view("users.permissions", [
            'user' => $user,
            "userPermissions" => $userPermissions
        ]);
    }

    public function edit(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // حذف الصلاحيات القديمة
        $user->permissions()->delete();

        // إضافة الصلاحيات الجديدة إذا وجدت
        if ($request->has('permissions')) {
            foreach ($request->permissions as $perm) {
                $user->permissions()->create(['permission' => $perm]);
            }
        }

        return redirect()->back()->with('success', 'تم تحديث الصلاحيات بنجاح');
    }
}
