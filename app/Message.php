<?php

namespace App;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const STATUS_INVALID_NUMBER = 'INVALID_NUMBER';
    const STATUS_NEW = 'NEW';
    const STATUS_FETCHED = 'FETCHED';
    const STATUS_SENT = 'SENT';
    const STATUS_DELIVERED = 'DELIVERED';
    const STATUS_READ = 'READ';
    const STATUS_SENT_NOT_CHECKED = 'SENT_NOT_CHECKED';
    public static function statusBr($status)
    {
        switch ($status){
            case Message::STATUS_INVALID_NUMBER:{
                return 'Número inválido';
            }
            case Message::STATUS_NEW:{
                return 'Nova';
            }
            case Message::STATUS_FETCHED:{
                return 'Consultada';
            }
            case Message::STATUS_SENT:{
                return 'Enviada';
            }
            case Message::STATUS_DELIVERED:{
                return 'Entregue';
            }
            case Message::STATUS_READ:{
                return 'Lida';
            }
            case Message::STATUS_SENT_NOT_CHECKED:{
                return 'Não verificada';
            }
        }
    }
}
