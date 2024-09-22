<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class AssetManagementController extends Controller
{
   
    public function index()
    {
      return redirect('/asset-management/location');
       
    }

  
}
