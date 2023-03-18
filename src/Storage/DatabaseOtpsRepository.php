<?php

namespace DanielRobert\Otp\Storage;

use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use DanielRobert\Otp\Contracts\ClearableRepository;
use DanielRobert\Otp\Contracts\PrunableRepository;

class DatabaseOtpsRepository implements ClearableRepository, PrunableRepository
{

    /**
     * The database connection name that should be used.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new database repository.
     *
     * @param  string  $connection
     * @return void
     */
    public function __construct(string $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Prune all of the entries older than the given date.
     *
     * @param  \DateTimeInterface  $before
     * @return int
     */
    public function prune(DateTimeInterface $before)
    {
        $query = $this->table('otps')->where('expired', true)->orWhere('created_at', '<', $before);

        $totalDeleted = 0;

        do {
            $deleted = $query->take(100)->delete();

            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        return $totalDeleted;
    }

    /**
     * Clear all the entries.
     *
     * @return void
     */
    public function clear()
    {
        $this->table('otps')->delete();
    }

    /**
     * Get a query builder instance for the given table.
     *
     * @param  string  $table
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table($table)
    {
        return DB::connection($this->connection)->table($table);
    }
}
