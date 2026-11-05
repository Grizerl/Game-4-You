<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $term = trim((string) $request->query('q', ''));

        $users = User::query()
            ->when($term !== '', function ($query) use ($term): void {
                $like = '%'.addcslashes($term, '%_\\').'%';
                $query->where(fn ($q) => $q->where('name', 'like', $like)->orWhere('email', 'like', $like));
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('dashboard.users.create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = new User($request->safe()->only(['name', 'email', 'password']));
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('users.index')->with('status', "User {$user->name} created.");
    }

    public function edit(User $user): View
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', "User {$user->name} updated.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()?->is($user)) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', "User {$user->name} deleted.");
    }
}
