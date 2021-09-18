<?php

namespace App\Http\Controllers\Api;

use App\DatacenterInfo;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use function response;

class DatacenterInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request, $token = null)
    {
        $validToken = $this->validToken($token);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];

        $datacenterInfo = new DatacenterInfo();
        $datacenterInfo->temperature = $request->temperature;
        $datacenterInfo->humidity = $request->humidity;
        $datacenterInfo->user_id = $user->id;
        $notification = false;
        $telephonesToSend =
            [
                //'81994885125', //Waldeildo Junior
                '81982001303',
                /*, '81988981549',*/ //maria
                //'87998096166',  //Joao
                //'81996851660',
                /*'81998692472', //Aline
                '81997869245', //Vildson
                '81997934304', //Igor Farias
                '87999265912', //Carlos
                '81996423176', //Carlos Lima
                '81981616971', //Marcelo
                */
                ''
            ];
        $phoneFrom = '5581982001303';
        $wasendController = new WASendController();
        $notification = true;
        if (!($datacenterInfo->temperature >= 15 && $datacenterInfo->temperature <= 25)) {
            for ($i = 0; $i < count($telephonesToSend); $i++) {
                /*if ($datacenterInfo->temperature < 15) {
                    $request->message = 'Bicho, o datacenter vai congelar: ' . $datacenterInfo->temperature . 'º';
                }*/
                /*if ($datacenterInfo->temperature > 25) { */
                $request->message = 'COMPESA: Alerta de temperatura no *datacenter* fora dos padrões (15º-25º). *Último registro: ' . $datacenterInfo->temperature . 'º*'
                    . "\n\n```Esta é uma mensagem automática. Por favor, não responda.```\n\n*OBS.: ISSO É APENAS UM TESTE*";
                /*}*/
                $request->to = $telephonesToSend[$i];
                $wasendController->send($request, $token, $phoneFrom);
            }
        }
        if (!($datacenterInfo->humidity >= 30 && $datacenterInfo->humidity <= 75)) {
            for ($i = 0; $i < count($telephonesToSend); $i++) {
                $request->message = 'COMPESA: Alerta de umidade no *datacenter* fora dos padrões (30%-75%). *Útltimo registro: ' . $datacenterInfo->humidity . '%*';
                $request->to = $telephonesToSend[$i];
                $wasendController->send($request, $token, $phoneFrom);
            }
        }
        return response()->json([
            'stored' => $datacenterInfo->save(),
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'send_to_whatsapp' => $notification
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function last($token)
    {
        $validToken = $this->validToken($token);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];

        $datacenterInfo = DatacenterInfo::all()->last();
        return response()->json([
            'temperature' => $datacenterInfo->temperature,
            'humidity' => $datacenterInfo->humidity
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function validToken($token)
    {
        $user = User::findByToken($token);
        if (!$user) {
            return response()->json(['error' => ['message' => 'Invalid token']]);
        }
        return ['user' => $user];
    }

}
