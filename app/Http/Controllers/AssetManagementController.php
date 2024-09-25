<?php

namespace App\Http\Controllers;

class AssetManagementController extends Controller
{
    public function index()
    {
        return redirect('/asset-management/location');

    }
}
