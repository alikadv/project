<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Metric;
use App\Models\Alert;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Response;
use App\Http\Requests\CollectRequest;
use PhpOption\None;

class MetricController extends Controller
{
    public function index(Request $request){
        return Sensor::all();
    }

    public function collect(CollectRequest $request, $uuid){
        // Validate uuid
        if (!Str::isUuid($uuid))
        return Response::json(['message' => 'Bad Uuid'],400);

        //Convert time
        $data = $request->all();
        $time =str_replace("+00:00","", $data['time']);

        // Save data
        try{
        $time = Carbon::createFromFormat('Y-m-d\TH:i:s', $time);
        $sensor = Sensor::select("id","uuid", "status")->where('uuid',$uuid)->get();

        $len=count($sensor);
        if ($len){
            $sensor=$sensor[0];
        }else{
            $sensor = Sensor::create(["uuid" =>$uuid ]);
        }
        $m=Metric::create(["co2"=>$data['co2'],"time"=>$time,"sensor_id"=> $sensor->id]);

        // change status to WARN
        if($m->co2>2000 && $sensor->status=="OK"){
            $sensor->status="WARN";
            $sensor->save();
        };
    } catch (\Exception $e) {

        return  Response::json(['message' => $e->getMessage()],500);
    }

    // Generate alerts
    if ( $sensor->status="WARN"){
        $co2s=Metric::where('sensor_id',$sensor->id)->limit(3)->orderBy('id', 'DESC')->pluck('co2')->toArray();
        $c=count(array_filter($co2s, function($var){return $var>2000;}));

        if ($c==3){
            $sensor->status="ALERT";
            $sensor->save();
            $Alert=Alert::create(([
                'startTime'=>$time,
                'endTime'=>Null,
                'mesurement1'=>$co2s[2],
                'mesurement2'=>$co2s[1],
                'mesurement3'=>$co2s[0],
                'sensor_id' => $sensor->id,
            ]));
        }
    }

    // Move Status to "OK"
    if ( $sensor->status="ALERT"){
        $co2s=Metric::where('sensor_id',$sensor->id)->limit(3)->orderBy('id', 'DESC')->pluck('co2')->toArray();
        $c=count(array_filter($co2s, function($var){return $var<=2000;}));

        if ($c==3){
            $sensor->status="OK";
            $sensor->save();
            $Alert=Alert::where('sensor_id',$sensor->id)->orderBy('id', 'DESC')->limit(1)->get();
            if (count($Alert)==1){
                $Alert=$Alert[0];
                $Alert->endTime=$time;
                $Alert->save();
            }
            dd($Alert, $c);
        }
    }
        return Response::json(['message' => "Data saved", "data"=>$sensor],200);
    }

    public function status($uuid){
         // Validate uuid
         if (!Str::isUuid($uuid))
         return Response::json(['message' => 'Bad Uuid'],400);

         $sensor=Sensor::where('uuid',$uuid)->get();
         if (count($sensor)!=1)
         return Response::json(['message' => 'Bad Uuid'],400);

         $sensor=$sensor[0];
         return Response::json(['status' =>$sensor->status],200);

    }

    public function metrics($uuid){
        if (!Str::isUuid($uuid))
         return Response::json(['message' => 'Bad Uuid'],400);

         $sensor=Sensor::where('uuid',$uuid)->get();
         if (count($sensor)!=1)
         return Response::json(['message' => 'Bad Uuid'],400);
         $sensor=$sensor[0];

         $current = Carbon::now();
         $time=$current->subDays(30);
         $co2s=Metric::where('sensor_id',$sensor->id)->whereDate('time', '>=',$time )->pluck('co2')->toArray();
         if (count($co2s)==0)
         return Response::json(['message' => 'No records for this sensor'],400);

         return Response::json(['maxLast30Days' => max($co2s),'avgLast30Days' =>array_sum($co2s)/count($co2s)],400);

    }

    public function alerts($uuid){
        if (!Str::isUuid($uuid))
         return Response::json(['message' => 'Bad Uuid'],400);

         $sensor=Sensor::where('uuid',$uuid)->get();
         if (count($sensor)!=1)
         return Response::json(['message' => 'Bad Uuid'],400);
         $sensor=$sensor[0];

         $alerts=Alert::select('startTime','endTime','mesurement1','mesurement2','mesurement3')->where('sensor_id',$sensor->id)->get();

         return Response::json($alerts,400);

    }
}
