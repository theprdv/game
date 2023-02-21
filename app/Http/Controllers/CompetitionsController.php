<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionStoreRequest;
use App\Http\Requests\CompetitionUpdateRequest;
use App\Http\Resources\CompetitionCollection;
use App\Http\Resources\CompetitionResource;
use App\Http\Resources\PlayerResource;
use App\Models\Competition;
use App\Models\Player;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CompetitionsController extends Controller
{
    public function index()
    {
        $all = Competition::all();

        return (new CompetitionCollection($all));
    }

    public function store(CompetitionStoreRequest $request)
    {
        Competition::create($request->all());

        return response([], ResponseAlias::HTTP_CREATED);
    }

    public function show(Competition $competition)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $competition->playersByScore()->paginate(2);
        $players = $paginator->items();
        $paginator->setCollection(new Collection());

        return (new JsonResource($paginator))->additional([
            'data' => [
                'competition' => new CompetitionResource($competition),
                'players' => PlayerResource::collection($players),
            ]
        ]);
    }

    public function update(CompetitionUpdateRequest $request, Competition $competition)
    {
        $competition->update($request->only('name', 'limit'));

        return (new CompetitionResource($competition));
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }

    public function addPlayer(Competition $competition, Player $player)
    {
        $status = ResponseAlias::HTTP_CREATED;
        $exceededLimit = $competition->players->count() >= $competition->limit;
        $exists = $competition->players->contains($player->id);

        if ($exceededLimit) {
            $status = ResponseAlias::HTTP_FORBIDDEN;
        } elseif ($exists) {
            $status = ResponseAlias::HTTP_CONFLICT;
        } else {
            $competition->players()->attach($player->id);
        }


        return response([], $status);
    }

    public function incrementPlayerScore(Competition $competition, Player $player)
    {
        $status = ResponseAlias::HTTP_NO_CONTENT;
        $exists = $competition->players->contains($player->id);

        if (!$exists) {
            $status = ResponseAlias::HTTP_FORBIDDEN;
        } else {
            $competition->playerScoreIncrement($player);
        }

        return response([], $status);
    }
}
