<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabEnvironment;
use Illuminate\Http\Request;

class LabEnvironmentController extends Controller
{
    public function index()
    {
        $environments = LabEnvironment::all();
        return view('admin.lab_environments.index', compact('environments'));
    }

    public function create()
    {
        return view('admin.lab_environments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'schema_name' => 'required|string',
            'setup_script' => 'nullable|string',
            'teardown_script' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        LabEnvironment::create($request->all());

        return redirect()->route('admin.lab-environments.index')->with('success', 'Lab Environment created successfully.');
    }

    public function edit($id)
    {
        $environment = LabEnvironment::findOrFail($id);
        return view('admin.lab_environments.edit', compact('environment'));
    }

    public function update(Request $request, $id)
    {
        $environment = LabEnvironment::findOrFail($id);

        $request->validate([
            'schema_name' => 'required|string',
            'setup_script' => 'nullable|string',
            'teardown_script' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        $environment->update($request->all());

        return redirect()->route('admin.lab-environments.index')->with('success', 'Lab Environment updated.');
    }

    public function destroy($id)
    {
        LabEnvironment::destroy($id);
        return redirect()->route('admin.lab-environments.index')->with('success', 'Deleted successfully.');
    }
}
