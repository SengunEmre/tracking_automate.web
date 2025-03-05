<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    // If your table name doesn't follow Laravel's naming convention (i.e. plural),
    // specify it here explicitly:
    protected $table = 'logs';

    // If the primary key is not 'id', set it here:
    protected $primaryKey = 'log_id';

    // (Optional) Disable auto-increment if 'log_id' is not auto-increment:
    // public $incrementing = false;

    // (Optional) If you don't have created_at/updated_at columns, disable timestamps:
    ///public $timestamps = false;
    protected $connection = 'mysql2';

    // Specify fillable columns (if you use mass assignment):
    protected $fillable = [
        'log_id',
        'logger_name',
        'request_id',
        'data',
        'logs',
        'exceptions',
        'exception_status',
        'email_status',
        'update_status', 
        'timestamp'
    ];
}
