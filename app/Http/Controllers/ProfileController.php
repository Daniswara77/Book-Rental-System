<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Rental;
use App\Models\Books;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showReaders()
    {
        $users = User::where('role', 'reader')->get();

        return view('profile.readerlist', compact('users'));
    }

    public function showLibrarians()
    {
        $users = User::where('role', 'librarian')->get();

        return view('profile.librarianlist', compact('users'));
    }

    public function changeLibrarianToReader(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 'reader',
        ]);

        return back()->with('success', 'Librarian role removed.');
    }

    public function changeReaderToLibrarian (Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 'librarian',
        ]);

        return back()->with('success', 'Librarian role added.');
    }
}
