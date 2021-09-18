<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use function response;

class WASendController extends Controller
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
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function setInvalidNumber($token, $telephone, $uuid)
    {
        $validToken = $this->validToken($token, $telephone);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];
        $message = $user->messages()->where('uuid', '=', $uuid)->first();
        $message->status = Message::STATUS_INVALID_NUMBER;
        return response()->json($message->save());
    }

    public function updateStatus($token, $telephone, $uuid, $status)
    {
        $validToken = $this->validToken($token, $telephone);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];
        $message = $user->messages()->where('uuid', '=', $uuid)->first();
        $message->status = $status;
        return response()->json($message->save());
    }

    public function messages($token, $telephone)
    {
        $validToken = $this->validToken($token, $telephone);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];
        $messages = $user->messages()->where('status', '=', Message::STATUS_NEW)->where('whatsapp_number_that_will_send', '=', $telephone);

        $messagesToSend = $messages->get(['message', 'to', 'status', 'uuid', 'created_at']);

        $messages->update(['status' => Message::STATUS_FETCHED]);
        return response()->json(['messages' => $messagesToSend]);
    }

    public function send(Request $request, $token, $telephone)
    {
        $validToken = $this->validToken($token, $telephone);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];

        $message = new Message();
        $message->message = $request->message;
        $message->to = $request->to;
        $message->user_id = $user->id;
        $message->status = Message::STATUS_NEW;
        $message->uuid = Str::uuid();
        $message->whatsapp_number_that_will_send = $telephone;
        $message->save();
        return response()->json($message->only(['message', 'status', 'to', 'uuid']));
    }

    public function validToken($token, $telephone)
    {
        if (strlen($telephone) < 9) {
            return response()->json(['error' => ['message' => 'Number of whatsapp web invalid']]);
        }

        $user = User::findByToken($token);

        if (!$user) {
            return response()->json(['error' => ['message' => 'Invalid token']]);
        }

        if (!($user->configurations()->count() > 0)) {
            return response()->json(['error' => ['message' => 'User without configuration']]);
        }

        if (!($userConfig = $user->configuration($telephone))) {
            return response()->json(['error' => ['message' => 'Configuration whatsapp number invalid']]);
        }

        if (!str_ends_with($userConfig->whatsapptelephone, $telephone)) {
            return response()->json(['error' => ['message' => 'Number of whatsapp web invalid']]);
        }

        return ['user' => $user];
    }

    public function checkEmail($token, $telephone)
    {
        $validToken = $this->validToken($token, $telephone);
        if ($validToken instanceof \Illuminate\Http\JsonResponse) {
            return $validToken;
        }
        $user = $validToken['user'];
        $userConfig = $user->configuration($telephone);
        if (!$userConfig->checkemail) {
            return response()->json(['error' => ['message' => 'Configuration is marked to not check e-mail']]);
        }

        $mbox = \imap_open('{' . $userConfig->imap_host . ':' . $userConfig->imap_port . '}', $userConfig->imap_user, $userConfig->imap_password);
        $folders = imap_listmailbox($mbox, '{' . $userConfig->imap_host . ':' . $userConfig->imap_port . '}', "*");

        if ($folders == false) {
            return response()->json(['error' => ['message' => 'Call failed']]);
        }
        $MC = imap_check($mbox);
        $result = imap_fetch_overview($mbox, "1:{$MC->Nmsgs}", 0);
//        $result = imap_search($mbox, 'RECENT', 0);
//        dd($result);
        foreach ($result as $overview) {
            if (new \DateTime($overview->date) > $userConfig->updated_at) {
                $go = empty($userConfig->onlyfrom);
                if (!$go) {
                    foreach (explode(';', $userConfig->onlyfrom) as $from) {
                        $from = trim($from);
                        if (Str::contains($overview->from, $from)) {
                            $go = true;
                            break;
                        }
                    }
                }
                if ($go) {
                    $jaFoi = false;
                    $uuidMessageBd = $overview->to . '|' . $overview->uid;
                    foreach ($user->messages()->get() as $messageUser) {
                        if ($messageUser->uuid == $uuidMessageBd) {
                            $jaFoi = true;
                            break;
                        }
                    }
                    if (!$jaFoi) {
                        $subject = $overview->subject;
                        $elements = imap_mime_header_decode($overview->subject);
                        for ($i = 0; $i < count($elements); $i++) {
                            $subject = "{$elements[$i]->text}";
                        }
                        $body = imap_fetchbody($mbox, $overview->msgno, 1.2);
                        if (!strlen($body) > 0) {
                            $body = imap_fetchbody($mbox, $overview->msgno, 1);
                        }
                        $body = strlen($body) > 200 ? substr($body, 0, 250) . "*...*\nPara ler o restante, abra seu e-mail." : $body;
                        $message = new Message();
                        $message->message = 'Você recebeu um novo e-mail de *' . trim($overview->from) . '*.' . "\n" . '*Assunto*: ' . $subject . "\n" . "*Conteúdo*:\n" . $body;
                        $message->to = urldecode($userConfig->whatsapptelephone);
                        $message->user_id = $user->id;
                        $message->status = Message::STATUS_NEW;
                        $message->uuid = $uuidMessageBd;
                        $message->whatsapp_number_that_will_send = $telephone;
                        $message->save();
                    }
                }
                $userConfig->touch();
            }
        }
        imap_close($mbox);
        return response()->json(true);
    }
}
