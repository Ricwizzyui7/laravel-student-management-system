<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    /**
     * Show admin settings dashboard.
     */
    public function index(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $settings = [
            'system_name' => SystemSetting::get('system_name', 'Student Management System'),
            'institution_name' => SystemSetting::get('institution_name', 'Global Institute of Technology'),
            'institution_logo' => SystemSetting::get('institution_logo'),
            'contact_email' => SystemSetting::get('contact_email', 'info@example.com'),
            'contact_phone' => SystemSetting::get('contact_phone', '+1-555-0000'),
            'contact_address' => SystemSetting::get('contact_address', '123 Education St, City'),
            'academic_year' => SystemSetting::get('academic_year', date('Y') . '-' . (date('Y') + 1)),
        ];

        return view('settings.admin.index', compact('settings'));
    }

    /**
     * Update system name.
     */
    public function updateSystemName(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'system_name' => ['required', 'string', 'max:255'],
        ]);

        SystemSetting::put('system_name', $validated['system_name']);

        return redirect()->back()->with('success', 'System name updated successfully.');
    }

    /**
     * Update institution info.
     */
    public function updateInstitution(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
        ]);

        SystemSetting::put('institution_name', $validated['institution_name']);

        return redirect()->back()->with('success', 'Institution name updated successfully.');
    }

    /**
     * Update institution logo.
     */
    public function updateLogo(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'institution_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('institution_logo')) {
            // Delete old logo if exists
            $oldPath = SystemSetting::get('institution_logo');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Store new logo
            $path = $request->file('institution_logo')->store('logos', 'public');
            SystemSetting::put('institution_logo', $path);
        }

        return redirect()->back()->with('success', 'Institution logo updated successfully.');
    }

    /**
     * Update contact information.
     */
    public function updateContact(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_address' => ['required', 'string', 'max:500'],
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::put($key, $value);
        }

        return redirect()->back()->with('success', 'Contact information updated successfully.');
    }

    /**
     * Update academic year.
     */
    public function updateAcademicYear(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'academic_year' => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
        ]);

        SystemSetting::put('academic_year', $validated['academic_year']);

        return redirect()->back()->with('success', 'Academic year updated successfully.');
    }
}
