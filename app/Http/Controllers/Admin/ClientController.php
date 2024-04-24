<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a list of the latest clients.
     *
     * This method is responsible for retrieving a list of the latest clients
     * from the database. It retrieves the latest 10 clients based on their
     * creation timestamps and returns them as a collection.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function index()
    {
        return Client::latest()->limit(10)->get();
    }
}
