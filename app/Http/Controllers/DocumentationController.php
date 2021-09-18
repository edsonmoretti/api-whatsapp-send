<?php

namespace App\Http\Controllers;

use App\Configuration;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('documentation', [
            'user' => Auth::user()
        ]);
    }

    public function create(Request $request)
    {
        $config = new Configuration();
        $config->whatsapptelephone = $request->whatsapptelephone;
        $config->api_token = Str::uuid();
        $config->user_id = $request->user()->id;
        $config->checkemail = isset($request->checkemail);
        $config->onlyfrom = $request->onlyfrom;
        $config->imap_host = $request->imap_host;
        $config->imap_port = $request->imap_port;
        $config->imap_user = $request->imap_user;
        $config->imap_password = $request->imap_password;
        $success = $config->save();
        return redirect()->back()
            ->with($success ? 'success' : 'error', $success ? 'Salvo com sucesso!' : 'Algum erro ocorreu!');
    }

    public function destroy(Configuration $configuration)
    {
        $success = $configuration->delete();
        return redirect()->back()
            ->with($success ? 'success' : 'error', $success ? 'Excluido com sucesso!' : 'Algum erro ocorreu!');
    }
}
