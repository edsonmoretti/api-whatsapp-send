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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use function response;

class DatacenterInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $zabbixLoginToken = '';
//    private $whatsAppToken = '4f45ae19-b8ad-4821-9611-866a6c96b65e';
    private $whatsAppToken = 'f2085361-27b5-4953-8617-83b14473343f';
    private $phoneFrom = '5581971096881';

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
    public function last(Request $request)
    {
        if (empty($this->zabbixLoginToken)) {
            $this->zabbixLogin();
        }
        $data = $this->postZabbix('{
            "jsonrpc": "2.0",
            "method": "problem.get",
            "params": {
                "output": "extend",
                "selectAcknowledges": "extend",
                "selectTags": "extend",
                "selectSuppressionData": "extend",
                "recent": "true",
                "sortfield": ["eventid"],
                "sortorder": "DESC"
            },
            "auth": "' . $this->zabbixLoginToken . '",
            "id": 1
        }');
        if (isset($data->result)) {
            if (empty($data->result)) {
                $response = [
                    "code" => "success",
                    "message" => "Que legal, não temos nenhum incidente recente"
                ];

            } else {
                $total = count($data->result);
                $lastMessage = $data->result[0]->name;
                $response = [
                    "code" => "success",
                    "message" => "Tivemos um total de "
                        . $total . ($total > 1 ? " incidentes. " : " incidemte. ")
                        . "O último foi: " . str_replace('<', '', $this->translate($lastMessage))
                ];
            }
        }
        try {
            $wasendController = new WASendController();
            $request->message = $response['message'];
            $request->to = '81982001303';
            $wasendController->send($request, $this->whatsAppToken, $this->phoneFrom);
        } catch (\Exception $ex) {
            $response['whatsappError'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    private function translate($q, $sl = "en", $tl = "pt")
    {
        $res = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&ie=UTF-8&oe=UTF-8&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&sl=" . $sl . "&tl=" . $tl . "&hl=hl&q=" . urlencode($q), $_SERVER['DOCUMENT_ROOT'] . "/transes.html");
        $res = json_decode($res);
        return $res[0][0][0];
    }

    private function zabbixLogin()
    {
        //TODO: pegar do banco de dados, configurado via WEB
        $user = 'Admin';
        $password = 'zabbix';
        $data = $this->postZabbix('{
                "jsonrpc": "2.0",
                "method": "user.login",
                "params": {
                    "user": "' . $user . '",
                    "password": "' . $password . '"
                },
                "id": 1,
                "auth": null
            }');

        if (isset($data->error)) {
            //TODO: tratar esse erro aqui
            return $data;
        } else {
            return $this->zabbixLoginToken = $data->result;
        }
    }

    private function postZabbix($postField)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://edsonmoretti.ddns.net:8000/api_jsonrpc.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postField,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
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
