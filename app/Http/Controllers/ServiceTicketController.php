<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceTicketRequest;
use App\Models\ServiceTicket;

class ServiceTicketController extends Controller
{
    public function index()
        {
            return ServiceTicket::all();
        }

        public function store(ServiceTicketRequest $r)
        {
            ServiceTicket::create([
                'date_wo' => $r->date_wo,
                'branch' => $r->branch,
                'no_wo_client' => $r->no_wo_client,
                'type_wo' => $r->type_wo,
                'client' => $r->client,
                'teknisi' => $r->teknisi,
                'is_active' => $r->is_active ?? 1,
            ]);

            return response()->json(['message' => 'Successfully added data']);
        }

        public function show($id)
        {
            return ServiceTicket::findOrFail($id);
        }

        public function update(ServiceTicketRequest  $r, $id)
        {
            
            ServiceTicket::findOrFail($id)->update([
                'date_wo' => $r->date_wo,
                'branch' => $r->branch,
                'no_wo_client' => $r->no_wo_client,
                'type_wo' => $r->type_wo,
                'client' => $r->client,
                'teknisi' => $r->teknisi,
                'is_active' => $r->is_active ?? 1, 
            ]);
        
            return response()->json(['message' => 'Successfully updated data']);
        }

        public function destroy($id)
        {
            $data = ServiceTicket::findOrFail($id);
            $data->delete();

            return response()->json(['message' => 'Successfully deleted data']);
        }

        public function toggle($id)
        {
            $data = ServiceTicket::findOrFail($id);
            $data->is_active = !$data->is_active;
            $data->save();

            return response()->json(['message' => 'Status updated']);
        }
}
