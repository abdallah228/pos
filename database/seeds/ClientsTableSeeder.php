<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $clients = ['mohamed','ahmed'];
        foreach($clients as $client)
        Client::create([
            'name'=>$client,
            'mobile'=>12456789,
            'address'=>'denshway',
        ]);
    }
}
