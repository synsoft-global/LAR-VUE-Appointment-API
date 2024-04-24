<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a paginated list of users.
     *
     * This method is responsible for retrieving a paginated list of users from
     * the database. It optionally filters users based on the 'query' query parameter,
     * which represents the search query. It retrieves users whose names contain
     * the search query string. It also applies pagination based on the 'pagination_limit'
     * setting retrieved from the settings. It returns the paginated list of users.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    public function index()
    {
        $users = User::query()
            ->when(request('query'), function ($query, $searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(setting('pagination_limit'));

        return $users;
    }

    /**
     * Store a newly created user in the database.
     *
     * This method is responsible for creating a new user record in the database
     * based on the data provided in the request body. It validates the input data,
     * including name, email, and password fields. Upon successful validation, it
     * creates a new user record with the provided data and returns the created user.
     * 
     * @return \App\Models\User
     */
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
    }

    /**
     * Update the specified user in the database.
     *
     * This method is responsible for updating the details of the specified user
     * in the database based on the data provided in the request body. It expects
     * an instance of the User model representing the user to be updated. It also
     * validates the input data, including name, email, and password fields. Upon
     * successful validation, it updates the user record with the provided data
     * and returns the updated user.
     * 
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }

    /**
     * Remove the specified user from the database.
     *
     * This method is responsible for deleting the specified user from the database.
     * It expects an instance of the User model representing the user to be deleted.
     * Upon successful deletion, it returns a response with no content (204 No Content).
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destory(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    /**
     * Change the role of the specified user.
     *
     * This method is responsible for updating the role of the specified user
     * in the database based on the role provided in the request body. It expects
     * an instance of the User model representing the user whose role is to be
     * updated. Upon successful update, it returns a JSON response indicating success.
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changeRole(User $user)
    {
        $user->update([
            'role' => request('role'),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Bulk delete users from the database.
     *
     * This method is responsible for deleting multiple users from the database
     * based on the array of user IDs provided in the request body. It uses the
     * 'ids' parameter to determine which users to delete. Upon successful deletion,
     * it returns a JSON response with a success message.
     * 
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete()
    {
        User::whereIn('id', request('ids'))->delete();

        return response()->json(['message' => 'Users deleted successfully!']);
    }
}
