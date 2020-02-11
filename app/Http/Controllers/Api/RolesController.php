<?php

namespace App\Http\Controllers\Api;


use App\Http\Actions\RolesActions;
use Illuminate\Http\Request;
use App\Post;

class RolesController extends Controller
{
    public function self(Request $request)
    {
//dd('here with me');
            return (new RolesActions())->execute();
    }

}
