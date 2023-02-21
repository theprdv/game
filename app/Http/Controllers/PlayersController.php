<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PlayersController extends Controller
{
    public function index()
    {
        $all = Player::all();

        return (new PlayerCollection($all));
    }

    public function store(PlayerStoreRequest $request)
    {
        Player::create($request->all());

        return response([], ResponseAlias::HTTP_CREATED);
    }

    public function show(Player $player)
    {
        $player->load('competitions');

        return (new PlayerResource($player));
    }

    public function update(PlayerUpdateRequest $request, Player $player)
    {
        $player->update($request->only('name'));

        return (new PlayerResource($player));
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }
}
