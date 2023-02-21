<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * Class Competition
 *
 * @property int $id
 * @property string|null $name
 * @property int $limit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Player $players
 * @property Collection|Player $playersByScore
 *
 * @package App\Models
 */
class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'limit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'limit' => 'integer'
    ];

    /**
     * The players that belong to the competition.
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot('score');
    }

    /**
     * The players that belong to the competition ordered by score
     */
    public function playersByScore(): BelongsToMany
    {
        return $this->players()->orderByPivot('score', 'desc');
    }

    public function playerScoreIncrement(Player $player)
    {
        $this->players()->updateExistingPivot($player->id, ['score' => DB::raw('`score` + 1')]);
    }
}
