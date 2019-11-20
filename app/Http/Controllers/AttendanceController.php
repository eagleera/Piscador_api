<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use App\Http\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $monedas = [500, 200, 100, 50, 20, 10, 5];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $fecha)
    {
        $user = Auth::user();
        $attendance =  Attendance::where([
            'attendance_day'=> $fecha,
            'ranch_id' => $user->default_ranch
        ])->get();
        foreach($attendance as $att) {
            $att->addWorker();
            $att->status = boolval($att->status);
        }
        if(sizeof($attendance) == 0){
            return [];
        }
        return $attendance;
    }

    public function payday(Request $request) : array
    {
        $user = Auth::user();
        $init_date = $this->transformDate($request->input('init_date'));
        $end_date = $this->transformDate($request->input('end_date'));
        $attendance = Attendance::where('ranch_id', $user->default_ranch)
            ->whereBetween('attendance_day',[$init_date, $end_date])
            ->get();
        $attendance_workers = $this->orderAttendanceByWorker($attendance);
        $arr_cambio = $this->calculateCambio($attendance_workers);
        $total = $this->calculateTotal($arr_cambio[1]);
        $result['attendance'] = $arr_cambio[0];
        $result['cambio'] = $arr_cambio[1];
        $result['total'] = $total;
        return $result;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $workers = $request->input('workers');
        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));
        foreach($workers as $worker){
            $attendance = new Attendance;
            $attendance->ranch_id = $user->default_ranch;
            $attendance->worker_id = $worker['id']; 
            $attendance->status = $worker['attendance'];
            $attendance->attendance_day = $date;
            $attendance->save();
        }
        return response()->json(['msg' => 'registered']);
    }

    public function transformDate( string $date) : string
    {
        $date = str_replace('/', '-', $date);
        return date('Y-m-d', strtotime($date));
    }
    
    public function orderAttendanceByWorker(object $attendance) : array
    {
        $attendance_arr = [];
        $workers_arr = [];
        foreach($attendance as $att) {
            $att->addWorker();
            $att->worker->addRole();
            $att->worker->role->addTipo();
            if(!in_array($att->worker_id, $workers_arr)) {
                $attendance_arr[] = $this->addWorkerToAttendanceArray($att);
                $workers_arr[] = $att->worker_id;
            }else{
                $attendance_arr = $this->addNewDayToAttendanceOfWorker($attendance_arr, $att);
            }
        }
        return $attendance_arr;
    }

    public function addWorkerToAttendanceArray(object $attendance) : array
    {
        $info_arr = [];
        $info_arr['payday'] = [];
        $info_arr['worker_id'] = $attendance->worker_id;
        $info_arr['worker'] = $attendance->worker;
        $info_arr['total'] = $attendance->status == "1" ? $attendance->worker->role->cantidad : 0;
        array_push($info_arr['payday'],
            ['status' => $attendance->status, 'date' => $attendance->attendance_day]);
        return $info_arr;
    }

    public function addNewDayToAttendanceOfWorker(array $attendance_arr, object $currentAttendance) : array
    {
        foreach($attendance_arr as &$attend){
            if($attend['worker_id'] == $currentAttendance->worker_id){
                if($currentAttendance->status == "1") {
                    $attend['total'] = 
                        floatval($currentAttendance->worker->role->cantidad) +
                        floatval($attend['total']);
                }
                array_push($attend['payday'], 
                    ['status' => $currentAttendance->status, 'date' => $currentAttendance->attendance_day]);
            }
        }
        unset($attend);
        return $attendance_arr;
    }
    public function calculateCambio(array $attendance) : array
    {
        $total_cambio = [];
        foreach($attendance as &$att){
            $att['cambio'] = $this->calculateBills($att['total']);
            array_push($total_cambio, $att['cambio']);
        }
        unset($att);
        $result[] = $attendance;
        $result[] = $this->sumarArraysUnoSolo($total_cambio);
        return $result;
    }

    public function calculateTotal(array $cambio_arr)
    {
        $total = 0;
        foreach($cambio_arr as $key => $value){ 
            $total += $value * $this->monedas[$key];
        }
        return $total;
    }

    public function calculateBills(float $total)
    {
        $cambio = [0, 0, 0, 0, 0, 0, 0];
        for($i = 0; $i < sizeof($this->monedas); $i++) {
            // Si el importe actual, es superior a la moneda
            if ($total >= $this->monedas[$i]) {
                // obtenemos cantidad de monedas
                $cambio[$i] = intval($total / $this->monedas[$i]);
                // actualizamos el valor del importe que nos queda por didivir
                $total = number_format(($total - $cambio[$i] * $this->monedas[$i]) ,2);
            } else {
                $total = round($total/5) * 5;
                $cambio[$i] = intval($total / $this->monedas[$i]);
            }
        }
        return $cambio;
    }
    public function sumarArraysUnoSolo(array $cambio) : array
    {
        $merged = array();
        foreach ($cambio as $array)
        {
            foreach ($array as $key => $value)
            {
                if ( ! is_numeric($value))
                {
                    continue;
                }
                if ( ! isset($merged[$key]))
                {
                    $merged[$key] = $value;
                }
                else
                {
                    $merged[$key] += $value;
                }
            }
        }
        return $merged;
    }
}