<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\Citizen;
use App\Models\ProcedureType;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $procedures = Procedure::query()
            ->with(['citizen', 'procedureType'])
            ->when($search, function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('citizen', function ($qc) use ($search) {
                      $qc->where('full_name', 'like', "%{$search}%")
                         ->orWhere('curp', 'like', "%{$search}%");
                  })
                  ->orWhereHas('procedureType', function ($qt) use ($search) {
                      $qt->where('name', 'like', "%{$search}%");
                  });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('procedures.index', compact('procedures', 'search'));
    }

    public function create()
    {
        $citizens = Citizen::orderBy('full_name')->get(['id', 'full_name', 'curp']);
        $types = ProcedureType::orderBy('name')->get(['id', 'name']);

        return view('procedures.create', compact('citizens', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'citizen_id' => ['required', 'exists:citizens,id'],
            'procedure_type_id' => ['required', 'exists:procedure_types,id'],
            'submitted_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        // ✅ Folio municipal secuencial
        $validated['folio'] = $this->generateFolio();
        $validated['status'] = 'pendiente';

        Procedure::create($validated);

        return redirect()
            ->route('procedures.index')
            ->with('success', 'Trámite registrado correctamente.');
    }

    public function edit(Procedure $procedure)
    {
        $procedure->load(['citizen', 'procedureType']);

        $citizens = Citizen::orderBy('full_name')->get(['id', 'full_name', 'curp']);
        $types = ProcedureType::orderBy('name')->get(['id', 'name']);

        return view('procedures.edit', compact('procedure', 'citizens', 'types'));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $validated = $request->validate([
            'citizen_id' => ['required', 'exists:citizens,id'],
            'procedure_type_id' => ['required', 'exists:procedure_types,id'],
            'submitted_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:pendiente,aprobado,rechazado'],
        ]);

        $procedure->update($validated);

        return redirect()
            ->route('procedures.index')
            ->with('success', 'Trámite actualizado correctamente.');
    }

    // Estatus rápido desde la tabla
    public function updateStatus(Request $request, Procedure $procedure)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pendiente,aprobado,rechazado'],
        ]);

        $procedure->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('procedures.index')
            ->with('success', 'Estatus actualizado correctamente.');
    }

    public function destroy(Procedure $procedure)
    {
        $procedure->delete();

        return redirect()
            ->route('procedures.index')
            ->with('success', 'Trámite eliminado correctamente.');
    }

    /**
     * ✅ Genera folio secuencial por año:
     * JAM-TRM-2026-000001
     */
    private function generateFolio(): string
    {
        $code = env('MUNICIPALITY_CODE', 'MUN');
        $year = now()->format('Y');
        $prefix = "{$code}-TRM-{$year}-";

        // Tomamos el último folio del año (ordenado desc)
        $last = Procedure::where('folio', 'like', $prefix . '%')
            ->orderBy('folio', 'desc')
            ->value('folio');

        $nextNumber = 1;

        if ($last) {
            $lastNumber = (int) substr($last, -6);
            $nextNumber = $lastNumber + 1;
        }

        $sequence = str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);

        return $prefix . $sequence;
    }
}
