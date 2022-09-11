<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase; // Para executar as migrations antes do teste (agora que os testes são executados em memória)

    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created()
    {
        // Arrange
        /** @var SeriesRepository $repository*/
        $repository = $this->app->make(SeriesRepository::class);
        $request = new SeriesFormRequest();
        $request->nome = 'Nome';
        $request->seasonsQty = 1;
        $request->episodesPerSeason = 1;
        
        // Act
        $repository->add($request);

        // Assert
        $this->assertDataBaseHas('series', ['nome' => 'Nome']);
        $this->assertDataBaseHas('seasons', ['number' => 1]);
        $this->assertDataBaseHas('episodes', ['number' => 1]);
    }
}
