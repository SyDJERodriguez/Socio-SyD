<?php


namespace App\Helpers;


use App\Repositories\ClientNumberRepository;
use DB;

class ProcessCSVFile
{
    protected  $file_name       = null;
    protected  $html_email      = null;
    protected  $clients         = null;
    protected  $this            = null;
    protected $table_body_email = '<tr>'.
        '<th>Numero cliente</th>'.
        '<th>Flags</th>'.
        '<th>Creación SAP</th>'.
        '<th>Plazo</th> '.
        '<th>Estatus</th> </tr>';

    public function __construct($disk = 'ftp', $file_name = null)
    {
        $date_last = strtotime("-1 day");
        $this->disk = $disk;
        $this->file_name = ($file_name != null)?$file_name:'ignorar/clients'.date('Ymd',$date_last).'.csv';
    }

    public function process_file(){
        \Log::channel('job_clients')->info('Comenzando procesamiento de archivo: '.$this->file_name);
        if(!\Storage::disk($this->disk)->exists($this->file_name)){
            \Log::channel('job_clients')->info('NO SE ENCONTRO EL ARCHIVO: '.$this->file_name);
            return false;
        }
        try{
            $file = \Storage::disk($this->disk)->get($this->file_name);
            $lines = explode(PHP_EOL, $file);
            $clients = array();
            array_shift($lines); //se elimina la primera columna
            foreach ($lines as $line){
                $this->process_line($line);
            }
            $this->send_email();
        }catch(\Exception $exception){
            \Log::channel('job_clients')->info('Ocurrio un error: '.$exception->getMessage());
        }
    }

    private function send_email(){
        \Mail::send('Admin.Mail.process_ftp_file',['data'=>$this->table_body_email], function($m){
            $m->from('noreply@quaxar.info',"Club Dar");
            $m->to('agutierrez@quaxar.com', 'Erick O.')->subject('Archivo FTP Procesado Clubdar');
        });
    }

    private function process_line($line){
        if(isset($row[2]) && isset($row[2]) && isset($row[2])) {
            $row = str_getcsv($line);
            $this->table_body_email .= '<tr>';
            $date = explode('.', $row[2]);
            $client_number = '00' . $row[0];
            $client = array(
                'client_number' => $client_number,
                'flags' => 'new_client',
                'creacion_sap' => $date[2] . '-' . $date[1] . '-' . $date[0],
                'plazo' => $row[1],
                'source' => $this->file_name
            );
            $this->table_body_email .= "<td>" . $client['client_number'] . "</td>";
            $this->table_body_email .= "<td>" . $client['flags'] . "</td>";
            $this->table_body_email .= "<td>" . $client['creacion_sap'] . "</td>";
            $this->table_body_email .= "<td>" . $client['plazo'] . "</td>";
            $proccess = ClientNumberRepository::save_client_number($client);

            $this->table_body_email .= "<td>" . $proccess['msg'] . "</td>";
            $this->table_body_email .= '</tr>';
        }
    }
}