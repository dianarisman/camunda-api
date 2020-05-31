<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class camundaController extends Controller
{
    //
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $client;

    public function __construct()
    {
        //
        $this->client = new \GuzzleHttp\Client();
    }

    public function TaskStart(Request $req){
        $client = $this->client;
        $url    = env('BASE_URL')."/process-definition/key/$req->prosesName/start";
    
        $body = json_encode(
            [
                'variables' => [
                  'approved'=> [
                      'value' => 'true',
                      'type'  => 'Boolean']
                ]
            ]
              
        );
        $headers  = ['Content-Type' => 'application/json'];
        $response = $client->request('POST', $url, [
            'body'    => $body,
            'headers' => $headers
        ]); 
       
        $response = json_decode( $response->getBody()->getContents());
        $ProsesId = $response->id;
        // $req->session()->put('ProsesId',$ProsesId);
        session(['prosesId' => $ProsesId]);
        // $req->session()->put('nama','Diki Alfarabi Hadi');
        return response()->json(['message' =>session()->all()], 200);
    }
    
    public function TaskList($prosesId){
        $client = $this->client;
        $url    = env('BASE_URL')."/task";
        $body   = [
                'processInstanceId' => $prosesId
            ];
        $headers  = ['Content-Type' => 'application/json'];
        $response = $client->request('GET', $url, [
            'query' => $body
            // 'headers' => $headers
        ]); 
       
        $response = json_decode( $response->getBody()->getContents());
        $TaskId = $response->id;

        //panggil fungsi "TaskComplate" dg param TaskId
        $this->TaskComplate($TaskId);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $response
        ], 200);
    }


    public function TaskComplate($idTask){
        $client = $this->client;
        $url    = env('BASE_URL')."/task/$idTask/complete";
    
        $body = json_encode(
            [
                'variables' => [
                  'approved'=> [
                      'value' => 'true',
                      'type'  => 'Boolean']
                ]
            ]
              
        );
        $headers  = ['Content-Type' => 'application/json'];
        $response = $client->request('POST', $url, [
            'body'    => $body,
            'headers' => $headers
        ]); 
       
        $response = json_decode( $response->getBody()->getContents());
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $response
        ], 200);
    }


    public function Task(Request $req){
        $client = $this->client;
        $url    = env('BASE_URL')."/process-definition/key/$req->prosesName/start";

        $body = json_encode(
            [
                'variables' => [
                    'approved'=> [
                        'value' => 'true',
                        'type'  => 'Boolean']
                ]
            ]

        );
        $headers  = ['Content-Type' => 'application/json'];
        $response = $client->request('POST', $url, [
            'body'    => $body,
            'headers' => $headers
        ]);

        $response = json_decode( $response->getBody()->getContents());
        $ProsesId = $response->id;

        //panggil fungsi "TaskList" dg param ProsesId
        $this->TaskList($ProsesId);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $response
        ], 200);
    }
}
