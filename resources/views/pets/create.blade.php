@extends('layout')

@section('title', 'Utwórz')

@section('content')

    @isset($pet)
        <h1>Edytuj zwierzaka</h1>
    @else
        <h1>Utwórz zwierzaka</h1>
    @endisset

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="error"> {{ $error }} </span>
        @endforeach
    @endif

    <form method="POST" 
        @isset($pet)
            action="{{ route('pets.update', ['pet' => $pet['id']]) }}"
        @else
            action="{{ route('pets.store') }}"
        @endisset
    >
        @csrf

        @isset($pet)
            <input type="hidden" name="_method" value="PUT" />
        @endisset

        <label for="name"> Nazwa </label><br>   
        <input type="text" name="name" id="name" value={{ old('name', $pet["name"] ?? null) }}>
        <br><br>

        <label for="category"> Kategoria </label><br>
        <input type="text" name="category" id="category" value={{ old('category', $pet["category"]["name"] ?? null) }}>
        <br><br>

        <label for="status"> Status </label><br>
        <select name="status">
            @foreach(App\Http\Enums\PetStatus::labels() as $value => $label)
                <option value="{{ $value }}" @if( old('status', $pet['status'] ?? null) == $value) selected @endif> {{ $label }} </option>
            @endforeach
        </select>
        <br><br>

        <label for="tags"> Tagi (Wpisuj w oddzielnych liniach) </label><br>
        <textarea name="tags" id="tags" rows="5" > {{ old('tags', $pet["tags"] ?? "") }} </textarea>
        <br><br>

        <label for="photos"> Url zdjęć (Wpisuj w oddzielnych liniach) </label><br>
        <textarea name="photos" id="photos" rows="5"> {{ old('photos', $pet["photos"] ?? "") }} </textarea>
        <br><br>

        @isset($pet)
            <input type="submit" value="Zapisz">
        @else
            <input type="submit" value="Utwórz">
        @endisset

    </form>



    @isset($pet)
        <hr>
        <h1>Dodaj zdjęcie</h1>

        <label for="photos"> Url zdjęć (Wpisuj w oddzielnych liniach) </label><br>
        <textarea name="photos" id="photos" rows="5"> {{ old('photos', $pet["photos"] ?? "") }} </textarea>
    @endisset

@endsection