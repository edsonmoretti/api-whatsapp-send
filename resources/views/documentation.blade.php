@extends('template.layout')
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-12">
            <!-- Polar and Radar Chart -->
            <div class="card card-default">
                <div class="card-header justify-content-center">
                    <h2>API Tokens</h2>
                </div>
                <div class="card-body">
                    @foreach($user->configurations as $config)
                        <form action="{{ route('admin.documentation.destroy', ['configuration'=>$config->id]) }}"
                              method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-3 col-form-label">WhatsApp Número</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="api_token"
                                           value="{{ $config->whatsapptelephone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Token: </label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="api_token"
                                           value="{{ $config->api_token }}">
                                </div>
                            </div>
                            E-mail:
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Verifica e-mail? </label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                           value="{{ $config->checkemail?'Sim':'Não' }}">
                                </div>
                            </div>
                            @if($config->checkemail && $config->imap_host)
                                {{--                            @if(true)--}}
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Host </label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                               value="{{ $config->imap_host }}:{{ $config->imag_port }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">E-mail/Usuário </label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                               value="{{ $config->imap_user }}:{{ $config->imap_user }}">
                                    </div>
                                </div>
                            @endif
                            <button class="btn btn-sm btn-danger" type="submit"><small>Remover</small></button>
                            <hr>
                        </form>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="col-xl-6 col-lg-6 col-12">

            <!-- Polar and Radar Chart -->
            <div class="card card-default">
                <div class="card-header justify-content-center">
                    <h2>Adicionar Token</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documentation.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput">Número do whatsapp que enviará:</label>
                            <input type="text" class="form-control" name="whatsapptelephone"
                                   placeholder="Ex.: 5581982999999">
                        </div>
                        <hr>
                        <div class="card-header justify-content-center">
                            <h2>Receber mensagem por e-mail recebido</h2>
                        </div>
                        <div class="form-group row">
                            <label for="checkemail" class="col-sm-3 col-form-label">Ativado?</label>
                            <div class="col-sm-9">
                                <input type="checkbox"
                                       class="form-control text-left"
                                       id="checkemail" name="checkemail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label">Apenas de: </label>
                            <div class="col-sm-9">
                                <small>Separe os e-mails por ponto e virgula -> ;</small>
                                <textarea type="text" class="form-control" id="onlyfrom" name="onlyfrom"
                                          value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <small>Configurações - IMAP</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label">Servidor</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="imap_host" name="imap_host"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label">Porta</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="imap_port" name="imap_port"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label">E-mail/Usuário</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="imap_user" name="imap_user"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onlyfrom" class="col-sm-3 col-form-label">Senha</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="imap_password" name="imap_password"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-success" type="submit">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
