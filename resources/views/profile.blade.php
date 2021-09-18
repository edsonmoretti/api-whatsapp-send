@extends('template.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Dados cadastrais</h2>
                </div>
                <div class="card-body">
                    <form class="horizontal-form" action="{{ route('admin.user.update', ['user' => $user->id]) }}"
                          method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <div class="col-12 col-md-3 text-right">
                                <label for="name">Nome</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="name" name="name" class="form-control"
                                       placeholder="Nome completo" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-3 text-right">
                                <label for="cpf">CPF</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="cpf" id="cpf" class="form-control"
                                       placeholder="Ex.: 000.000.000-00" value="{{ old('cpf')?old('cpf'):$user->cpf }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-3 text-right">
                                <label for="email">E-mail</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="Ex.: seunome@provedor.com.br"
                                       value="{{ old('email')?old('email'):$user->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-md-3 text-right">
                                <label for="password">Senha</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Preencha para alterar" value="{{ old('password') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-3 text-right">
                                <label for="password_confirmation">Repita</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                       placeholder="Repita a senha" value="{{ old('password_confirmation') }}">
                            </div>
                        </div>

                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
