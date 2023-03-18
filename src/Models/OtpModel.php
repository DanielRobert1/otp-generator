<?php
namespace DanielRobert\Otp\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier', 
        'token',
        'validity',
        'expired',
        'no_times_generated',
        'generated_at',
    ];

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'otps';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'generated_at' => 'datetime',
    ];

    /**
     * Checks if otp is expired.
     *
     * @return bool
     */
    public function isExpired() :bool
    {
        if ($this->expired) {
            return true;
        }

        $generatedTime = $this->generated_at->addMinutes($this->validity);
       
        if (strtotime($generatedTime) >= strtotime(Carbon::now()->toDateTimeString())) {
            return false;
        }
        $this->expired = true;
        $this->save();

        return true;
    }

    /**
     * Sets the expiry date
     *
     * @return object
     */
    public function expiredAt() :object
    {
        return $this->generated_at->addMinutes($this->validity);
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return config('otp.storage.database.connection');
    }
}