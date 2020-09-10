<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

use App\Http\Requests;

class ClientController extends Controller
{
    public function getListClient(){
        return view('clients.list');
    }

    public function bulkAddClients(){
        return view('clients.bulkAddClients');
    }

    public function bulkValidate(Request $request) 
    {
        $file = $request->file('file');
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = array_map("str_getcsv", file($path));
            $csv_data = array_slice($data, 0);

            //flag to skip the first header row;
            $flag = FALSE;
            foreach ($csv_data as &$row) {
                if(!$flag){ 
                    $flag = TRUE;
                    continue; 
                }

                if(($this->valid_mobile($row[0])) && $this->valid_name($row[1]) && $this->valid_name($row[2]) && $this->valid_state($row[3])
                && $this->valid_address($row[4]) && $this->valid_email($row[5]) && $this->valid_deposit($row[6])){
                    $row[7] = "PASS";
                }else {
                    $row[7] = "FAIL";
                }
            }

            $json_data = json_encode($csv_data);
        return view('clients.validated_csv', compact('csv_data', 'json_data'));  
    }
}

    public function submitUsers(Request $request){
        $array = json_decode($request->json);
        $data = array();

        $client = new Client();
        $flag = FALSE;
        foreach ($array as $rec) {
            if(!$flag){
                array_push($data, $rec); 
                $flag = TRUE;
                continue; 
            }

            if($rec[7] !== "FAIL"){

                //create payload
                $info = array(
                    "imei" => "357925071763103",
                    "admin_id" => 1,
                    "channel" => "ANDROID",
                    "clients" => [[
                        "cardId" => "",
                        "clientClassOfServiceId" => [
                            "id" => 14
                        ],
                        "email" => $rec[5],
                        "pin" => "",
                        "deposit" => $rec[6],
                        "lastname" => $rec[2],
                        "agentId" => [
                            "id" => 914
                        ],
                        "firstname" => $rec[1],
                        "address" => $rec[4],
                        "documentId" => [
                            "vatRegistered" => false,
                            "gender" => "Male",
                            "idNumber" => "04065570X07"
                        ],
                        "mobile" => $rec[0],
                        "idNumber" => "04065570X07"
                    ]]
                );

                //send data
                $result = $client->post(env('BASE_URL') .'/client_crud/add', [
                    'headers' => ['Content-type' => 'application/json'],
                    'json' => $info
                ]);

                //store response
                $res = $result->getBody()->getContents();
                $response = json_decode($res, TRUE);
              
                if($response[0]['code'] == 00){
                    $rec[7] = "Successfully Registered";
                }elseif($response[0]['code'] == 01){
                    $rec[7] = "Error 2";
                }elseif($response[0]['code'] == 111){
                    $rec[7] = "User Already Exists";
                }elseif($response[0]['code'] == 400){
                    $rec[7] = "Invalid Data";
                }else {
                    $rec[7] = "Error";
                }

                array_push($data, $rec);  

            }

        }

        return $data;

        //Download CVS
        $filename = "results.csv";
        $handle = fopen($filename, 'w+');
        $csv_headers = ['mobile', 'firstname', 'lastname', 'state', 'address', 'email', 'deposit', 'status'];

        foreach ($data as $rec) {
            fputcsv($handle, $rec);
        }
    
        fclose($handle);
    
        $headers = array(
            'Content-Type' => 'text/csv',
        );
    
        return response()->download($filename, 'results.csv', $data);

    }

    public function exportTemplate(){

            $filename = "subscribers.csv";
            $handle = fopen($filename, 'w+');
            $csv_headers = ['mobile', 'firstname', 'lastname', 'state', 'address', 'email', 'deposit', 'status'];

            fputcsv($handle, $csv_headers );
        
            fclose($handle);
        
            $headers = array(
                'Content-Type' => 'text/csv',
            );
        
            return response()->download($filename, 'subscribers.csv', $headers);
    }

    public function disburmentsValidate(Request $request){
        $file = $request->file('file');
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = array_map("str_getcsv", file($path));
            $csv_data = array_slice($data, 0);

            //flag to skip the first header row;
            $flag = FALSE;
            foreach ($csv_data as &$row) {
                if(!$flag){ 
                    $flag = TRUE;
                    continue; 
                }

                if(($this->valid_mobile($row[0])) && $this->valid_destination($row[1])  && $this->valid_deposit($row[2])){
                    $row[3] = "PASS";
                }else {
                    $row[3] = "FAIL";
                }
            }

            $json_data = json_encode($csv_data);
        }

        return view('clients.validated_csv', compact('csv_data', 'json_data'));
    }

    public function submitDisbursment(Request $request){
        return $request->input('json');
    }

    public function exportDisbursmentsTemplate(){

        $filename = "disbursments.csv";
        $handle = fopen($filename, 'w+');
        $csv_headers = ['mobile', 'destination', 'amount', 'status'];

        fputcsv($handle, $csv_headers);
    
        fclose($handle);
    
        $headers = array(
            'Content-Type' => 'text/csv',
        );
    
        return response()->download($filename, 'disbursments.csv', $headers);
}

    public function getAddClient(){
        return view('clients.add');
    }

    public function getUpdateClient(){
        return view('clients.update');
    }

    // Validatio Functions
    public function valid_destination($mobile){
        if(!$mobile || !(preg_match('/^[0-9]{9}+$/', $mobile))){
            return FALSE;
        }else{
            return TRUE;
        }
    }


    public function valid_mobile($mobile){
        if(!$mobile || !(preg_match('/^[0-9]{9,12}+$/', $mobile))){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function valid_name($name){
        if(!$name || !(\preg_match('/^[a-zA-Z]+$/', $name))){
            return FALSE;
        }else {
            return TRUE;
        }
    }

    public function valid_state($state){
        if(!(preg_match('/^ACTIVE$|^INACTIVE$/', $state))){
            return FALSE;
        }else {
            return TRUE;
        }
    }

    public function valid_address($address){
        if(!$address || !(\preg_match('/^[a-zA-Z0-9,.\s]+$/', $address))){
            return FALSE;
        }else {
            return TRUE;
        }
    }

    public function valid_email($email){
        If(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return FALSE;
         }else {
             return TRUE;
         } 
    }

    public function valid_deposit($deposit){
        if(!(\preg_match('/^[0-9.\s]+$/', $deposit))){
            return FALSE;
        }else {
            return TRUE;
        }
    }
}
