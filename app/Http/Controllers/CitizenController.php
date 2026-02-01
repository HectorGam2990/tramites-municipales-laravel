<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $citizens = Citizen::query()
            ->when($search, function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('curp', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('full_name')
            ->paginate(10)
            ->withQueryString();

        return view('citizens.index', compact('citizens', 'search'));
    }

    public function create()
    {
        return view('citizens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'curp'      => ['required', 'string', 'size:18', 'unique:citizens,curp'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'email'     => ['nullable', 'email', 'max:255'],
        ]);

        Citizen::create($validated);

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Ciudadano registrado correctamente.');
    }

    public function edit(Citizen $citizen)
    {
        return view('citizens.edit', compact('citizen'));
    }

    public function update(Request $request, Citizen $citizen)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'curp'      => ['required', 'string', 'size:18', 'unique:citizens,curp,' . $citizen->id],
            'phone'     => ['nullable', 'string', 'max:30'],
            'email'     => ['nullable', 'email', 'max:255'],
        ]);

        $citizen->update($validated);

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Ciudadano actualizado correctamente.');
    }

    public function destroy(Citizen $citizen)
    {
        $citizen->delete();

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Ciudadano eliminado correctamente.');
    }
}
