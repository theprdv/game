<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Competition */
class CompetitionResource extends JsonResource
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
            'limit' => $this->limit,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'playersByScore' => PlayerResource::collection($this->whenLoaded('playersByScore')),
        ];
    }
}
