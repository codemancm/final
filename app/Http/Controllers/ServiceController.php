<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(32);
        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('manage_services') && !auth()->user()->isVendor()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'service_picture' => 'nullable|image|max:2048',
        ]);

        $service = new Service($request->all());
        $service->user_id = auth()->id();

        if ($request->hasFile('service_picture')) {
            $service->service_picture = $request->file('service_picture')->store('service_pictures', 'public');
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'service_picture' => 'nullable|image|max:2048',
        ]);

        $service->fill($request->except('service_picture'));

        if ($request->hasFile('service_picture')) {
            if ($service->service_picture) {
                Storage::disk('public')->delete($service->service_picture);
            }
            $service->service_picture = $request->file('service_picture')->store('service_pictures', 'public');
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->service_picture) {
            Storage::disk('public')->delete($service->service_picture);
        }
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
