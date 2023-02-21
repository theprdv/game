<?php

namespace App\Http\Resources;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Player */
class PlayerResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            'score' => $this->whenPivotLoaded('competition_player', function () {
                return $this->pivot->score;
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'competitions' => CompetitionResource::collection($this->whenLoaded('competitions')),
        ];
    }
}
