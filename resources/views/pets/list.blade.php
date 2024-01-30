@extends('layout')

@section('title', 'Lista')

@section('content')

    @if(session()->has('success'))
        <span class="success"> {{ session()->get('success') }} </span>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="error"> {{ $error }} </span>
        @endforeach
    @endif

    <a class="button" href="{{ route('pets.create') }}">
        Utwórz
    </a>

    <form>
        <fieldset>
            <legend>Status</legend>
            @foreach(App\Http\Enums\PetStatus::labels() as $value => $label)
                <input type="checkbox" id="status-{{ $value }}" name="status[]" value="{{ $value }}" {{ in_array($value, $statuses) ? "checked" : "" }}>
                <label for="status-{{ $value }}"> {{ $label }} </label><br>    
            @endforeach
            <input type="submit" value="Pokaż">
        </fieldset>
    </form>

    <table>
        <tr>
            <th>Nazwa</th>
            <th>Status</th>
            <th>Kategoria</th>
            <th>Tagi</th>
            <th>Akcje</th>
        </tr>

        @foreach($pets as $pet)
            <tr>
                <td> {{ isset($pet['name']) ? $pet['name'] :  "-"}} </td>
                <td> {{ isset($pet['status']) ? $pet['status'] :  "-"}} </td>
                <td> {{ isset($pet['category']['name']) ? $pet['category']['name'] :  "-"}} </td>
                <td>
                    @isset($pet['tags'])
                            @foreach ($pet['tags'] as $tag)
                            @isset($tag['name'])
                                <span class="tag"> {{ $tag['name'] }} </span>
                            @endisset
                        @endforeach
                    @else
                        -
                    @endisset
 
                </td>
                <td>

                    <form action="{{ route('pets.destroy', ['pet' => $pet['id']]) }}" method="post">
                        <input type="submit" value="Usuń" />
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>

                    <form action="{{ route('pets.download', ['pet' => $pet['id']]) }}" method="get">
                        <input type="submit" value="Pobierz" />
                    </form>

                    <form action="{{ route('pets.edit', ['pet' => $pet['id']]) }}" method="get">
                        <input type="submit" value="Edytuj" />
                    </form>

                </td>
            </tr>
        @endforeach

    </table>

@endsection