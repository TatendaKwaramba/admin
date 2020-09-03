<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            // Email Validation
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
        }

        return view('clients.validated_csv', compact('csv_data'));  
    }

    public function submitUsers(Request $request){

        $file = $request->file('file');
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = array_map("str_getcsv", file($path));
            $csv_data = array_slice($data, 0);

            // Email Validation
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
        }

        return $csv_data;
    }

    public function exportTemplate(){

            $filename = "subscribers.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('mobile', 'firstname', 'lastname', 'state', 'address', 'email', 'deposit', 'status'));
        
            fclose($handle);
        
            $headers = array(
                'Content-Type' => 'text/csv',
            );
        
            return Response::download($handle, 'subscribers.csv', $headers);
    }

    public function getAddClient(){
        return view('clients.add');
    }

    public function getUpdateClient(){
        return view('clients.update');
    }

    // Validatio Functions
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
        if(!(preg_match('/^ACTIVE$|^DISABLED$/', $state))){
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
