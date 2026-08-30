<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Settings', ['settings' => ['phone' => Setting::valueFor('phone'), 'whatsapp' => Setting::valueFor('whatsapp'), 'logo_url' => Setting::valueFor('logo_url'), 'favicon_url' => Setting::valueFor('favicon_url')]]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['phone' => ['nullable', 'string', 'max:30'], 'whatsapp' => ['nullable', 'string', 'max:30'], 'logo' => ['nullable', 'image', 'max:2048'], 'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp', 'max:1024']]);
        foreach (['phone', 'whatsapp'] as $key) Setting::updateOrCreate(['key' => $key], ['value' => $data[$key] ?? null]);
        if ($request->hasFile('logo')) $this->saveFile($request, 'logo', 'logo_url');
        if ($request->hasFile('favicon')) $this->saveFile($request, 'favicon', 'favicon_url');
        return back()->with('success', 'Contact and branding settings saved.');
    }

    private function saveFile(Request $request, string $input, string $key): void
    {
        $oldUrl = Setting::valueFor($key);
        if ($oldUrl && str_starts_with($oldUrl, '/storage/')) Storage::disk('public')->delete(str_replace('/storage/', '', $oldUrl));
        $path = $request->file($input)->store('branding', 'public');
        Setting::updateOrCreate(['key' => $key], ['value' => Storage::disk('public')->url($path)]);
    }
}
