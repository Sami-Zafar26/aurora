<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntegrationService;

class IntegrationServiceController extends Controller
{
    public function integration_services() {
        $integration_services = IntegrationService::all();
        return view('admin.integration-service',['integration_services'=>$integration_services]);
    }
}
