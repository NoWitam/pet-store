<h2>Nazwa:</h2> <br>
<h1> {{ isset($pet['name']) ? $pet['name'] :  "-"}} </h1>
<hr>

<h2>Status:</h2> <br>
<h1> {{ isset($pet['status']) ? $pet['status'] :  "-"}} </h1>
<hr>

<h2>Kategoria:</h2> <br>
<h1> {{ isset($pet['category']['name']) ? $pet['category']['name'] :  "-"}} </h1>
<hr>

<h2>Status:</h2> <br>
<h1> {{ 
        isset($pet['status']) 
        ? App\Enums\PetStatus::tryFrom($pet['status'])?->label()
        :  "-"
    }} 
</h1>
<hr>

<h2>Tagi:</h2><br>
    @isset($pet['tags'])
        @foreach ($pet['tags'] as $tag)
            @isset($tag['name'])
                <span class="tag"> {{ $tag['name'] }} </span>
            @endisset
        @endforeach
    @endisset
<hr>

<h2>Zdjecia:</h2>
<div>
    @isset($pet['photoUrls'])
        @foreach ($pet["photoUrls"] as $url)
            <img src={{ $url }}>
        @endforeach
    @endisset
</div>

<style>
    * {
        margin: 0;
        padding: 0;
    }
    body {
        padding: 15px;
    }
    h1, h2 {
        margin-bottom: 10px;
    },
    hr {
        margin-bottom: 40px;
    }
    img {
        width: 200px;
        margin: 15px;
    }
</style>
