<?php

namespace App\Http\Controllers\Api;

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

    public function index()
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json($this->seriesRepository->add($request), Response::HTTP_CREATED);
    }

    public function show(int $series)
    {
        return Series::whereId($series)
            ->with('season.episodes')
            ->first();
    }

    public function update(int $series, SeriesFormRequest $request)
    {
        Series::where('id', $series)->update([
            'nome' => $request->nome
        ]);
        return response()->noContent();
    }

    public function destroy(int $series)
    {
        Series::destroy($series);
        return response()->noContent();
    }
}
