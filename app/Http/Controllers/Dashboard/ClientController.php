<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //search
      $clients = Client::when($request->search , function($q) use($request){
            return $q->where('name','like','%' . $request->search . '%')
                    ->orWhere('mobile','like','%' . $request->search . '%')
                    ->orWhere('address','like','%' .  $request->search . '%');
        })->latest()->paginate(2);

        //
       // $clients = Client::paginate(2);
        return view('dashboard.client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|array|min:1',
            'mobile.0'=>'required',
            'address'=>'required',
        ]);
            $request_data = $request->all();
            $request_data['mobile'] = array_filter($request->mobile);
             //dd($request_data);
            Client::create($request_data);
             return redirect()->route('clients.index')->with(["success"=>__('site.added_success')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
        return view('dashboard.client.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|array|min:1',
            'mobile.0'=>'required',
            'address'=>'required',
        ]);
            $request_data = $request->all();
            $request_data['mobile'] = array_filter($request->mobile);
             //dd($request_data);
            $client->update($request_data);
             return redirect()->route('clients.index')->with(["success"=>__('site.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        $client->delete();
        return redirect()->route('clients.index')->with(['success'=>__('site.delete_succes')]);
                                               
    }
}
