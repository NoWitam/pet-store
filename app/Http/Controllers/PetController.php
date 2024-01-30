<?php

namespace App\Http\Controllers;

use App\Http\Enums\PetStatus;
use App\Http\Requests\StorePetRequest;
use App\Http\Services\PetService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PetController extends Controller
{
    function __construct(
        private PetService $petService = new PetService()
    ){ }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = request()->get('status', []);

        return $this->resolveReposnse(

            $this->petService->list($statuses),

            function($pets) use ($statuses) {
                return view('pets.list', [
                    'pets' => $pets,
                    'statuses' => $statuses
                ]);
            },

            "Podano nieprawidłowy status"
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        return $this->resolveReposnse(

            $this->petService->create($request->only([
                'name',
                'category',
                'status',
                'tags',
                'photos'
            ])),

            function($pet) {
                return redirect()
                ->route('pets.edit', ["pet" => $pet['id']])
                ->with('success','Zwierzak utworzony pomyślnie');
            }
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->resolveReposnse(

            $this->petService->find($id),

            function($pet) {
                dd($pet);
                $pet['tags'] = isset($pet["tag"]) ? implode("\r\n", array_map(
                    fn($tag) => $tag['name'],
                    $pet['tags']
                )) : null;
        
                $pet['photos'] = isset($pet["photoUrls"]) ? implode("\r\n", $pet["photoUrls"]) : null;
        
                return view('pets.create', [
                    'pet' => $pet
                ]);
            }
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePetRequest $request, string $id)
    {
        return $this->resolveReposnse(

            $this->petService->update($id, $request->only([
                'name',
                'category',
                'status',
                'tags',
                'photos'
            ])),

            function($pet) use ($id) {
                return redirect()
                    ->route('pets.edit', ["pet" => $id])
                    ->with('success','Zwierzak edytowny pomyślnie');
            }
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->resolveReposnse(

            $this->petService->delete($id),

            function($pet) {
                return redirect()->back()->with('success','Zwierzak usunięty pomyślnie');
            }
        );
    }

    public function download(int $id)
    {
        return $this->resolveReposnse(

            $this->petService->find($id),

            function($pet) {
                return Pdf::loadView("pets.pdf", [
                    'pet' => $pet,
                ])->download($pet['name'] . ".pdf");
            }
        );
    }

    private function resolveReposnse($response, callable $default, $on400 = "Podano nieprawidłowy identyfikator")
    {
        $json = $response->json();

        if($response->ok()) {
            return $default($json);
        }

        return match($response->status()) 
        {
            404 => abort(404, "Zwierzak nie znaleziony"),
            400 => abort(400, $on400),
            405 => redirect()->back()->withErrors([$json['message']])->withInput(),
            default => abort($json['code'], $json['message']),
        };
    }
}
