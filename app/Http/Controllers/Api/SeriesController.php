<?php

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Series;
use App\Http\Requests\SeriesFormRequest;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    public function index(Request $request)
    {
        if (!$request->has('nome')) {
            return Series::paginate(2);
        }

        return Series::whereNome($request->nome)->get();
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json($this->seriesRepository->add($request), Response::HTTP_CREATED);
    }

    public function show(int $series)
    {
        return Series::with('season.episodes')->find($series)
            ?? response()->json([], Response::HTTP_NOT_FOUND);
    }

    public function update(int $series, SeriesFormRequest $request)
    {
        Series::where('id', $series)->update([
            'nome' => $request->nome
        ]);
        return response()->noContent();
    }

    public function destroy(int $series, Authenticatable $user)
    {
        if ($user->tokenCan('series:delete') === false) {
            return response()->json('Unauthorized', 401);
        }

        Series::destroy($series);
        return response()->noContent();
    }
}
