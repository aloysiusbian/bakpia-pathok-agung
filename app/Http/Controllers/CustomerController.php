public function editProfile() {
    return view('customer.edit_profile');
}

public function updateProfile(Request $request) {
    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;

    if ($request->hasFile('profile_image')) {
        $filename = time().'_'.$request->file('profile_image')->getClientOriginalName();
        $request->file('profile_image')->storeAs('public/profile', $filename);
        $user->profile_image = $filename;
    }

    $user->save();
    return redirect()->route('pelanggan.editProfile')->with('success', 'Profil berhasil diperbarui!');
}
public function showProfile() {
    return view('customer.profile');
}

