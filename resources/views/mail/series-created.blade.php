@component('mail::message')

# {{ $serieNome }} criada.

A série {{ $serieNome }} com {{ $temporadaQtd }} e {{ $temporadaEpisodios }} episódios por temporada foi criada.

Acesse aqui:

@component('mail::button', ['url' => route('seasons.index', $serieId)])
    Ver série
@endcomponent
 
@endcomponent