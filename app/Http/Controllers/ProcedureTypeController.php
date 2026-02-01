<?php

namespace App\Http\Controllers;

use App\Models\ProcedureType;
use Illuminate\Http\Request;

class ProcedureTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $types = ProcedureType::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('procedure_types.index', compact('types', 'search'));
    }

    public function create()
    {
        return view('procedure_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:procedure_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        ProcedureType::create($validated);

        return redirect()
            ->route('procedure-types.index')
            ->with('success', 'Tipo de trámite creado correctamente.');
    }

    public function edit(ProcedureType $procedure_type)
    {
        return view('procedure_types.edit', ['type' => $procedure_type]);
    }

    public function update(Request $request, ProcedureType $procedure_type)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:procedure_types,name,' . $procedure_type->id],
            'description' => ['nullable', 'string'],
        ]);

        $procedure_type->update($validated);

        return redirect()
            ->route('procedure-types.index')
            ->with('success', 'Tipo de trámite actualizado correctamente.');
    }

    public function destroy(ProcedureType $procedure_type)
    {
        $procedure_type->delete();

        return redirect()
            ->route('procedure-types.index')
            ->with('success', 'Tipo de trámite eliminado correctamente.');
    }
}
