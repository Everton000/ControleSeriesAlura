<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Autenticador;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Season;
use App\Http\Requests\SeriesFormRequest;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Autenticador::class)->except('index');
    }

    public function index()
    {
        $series = Series::with(['season'])->get();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $serie = $this->repository->add($request);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')
            ->with('series', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' editada com sucesso!");
    }

    public function destroy(Series $series)
    {
        $series->delete();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso!");
    }
}
