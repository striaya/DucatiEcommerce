<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user      = Auth::user()->load('addresses');
        $orders    = $user->orders()->latest()->limit(5)->get();
        $credits   = $user->creditApplications()->latest()->limit(3)->get();

        return view('user.profile', compact('user', 'orders', 'credits'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:100',
            'phone'     => 'nullable|string|max:20',
            'nik'       => 'nullable|string|size:16|unique:users,nik,' . $user->user_id . ',user_id',
        ]);

        $user->update($request->only('full_name', 'phone', 'nik'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function addresses()
    {
        $addresses = UserAddress::where('user_id', Auth::id())->get();
        return view('user.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'street'         => 'required|string',
            'city'           => 'required|string|max:80',
            'province'       => 'required|string|max:80',
            'postal_code'    => 'required|string|max:10',
            'is_default'     => 'boolean',
        ]);

        if ($request->boolean('is_default')) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        UserAddress::create(array_merge(
            $request->only('label', 'recipient_name', 'street', 'city', 'province', 'postal_code'),
            ['user_id' => Auth::id(), 'is_default' => $request->boolean('is_default')]
        ));

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function destroyAddress(int $id)
    {
        UserAddress::where('user_id', Auth::id())->findOrFail($id)->delete();
        return back()->with('success', 'Alamat dihapus.');
    }

    public function adminIndex()
    {
        $users = User::withCount(['orders', 'creditApplications'])->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function updateKyc(Request $request, int $id)
    {
        $request->validate(['kyc_status' => 'required|in:unverified,verified,rejected']);
        User::findOrFail($id)->update(['kyc_status' => $request->kyc_status]);
        return back()->with('success', 'Status KYC diperbarui.');
    }
}
