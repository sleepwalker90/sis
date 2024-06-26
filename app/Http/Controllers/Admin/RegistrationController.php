<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function toggleRegistration(Request $request)
    {
        // Determine if the toggle switch was "on" (meaning registration should be enabled)
        $status = $request->has('status') ? 'false' : 'true';

        // Find the setting in the database. Assuming 'key' is a unique identifier for settings.
        $setting = DB::table('settings')->where('key', 'disable_registration')->first();

        // Check if the setting exists to prevent errors
        if ($setting) {
            // Update the 'value' of the setting based on the toggle switch
            DB::table('settings')->where('key', 'disable_registration')->update([
                'value' => $status,
                // Optionally, track which user made the change by storing their user ID
                'user_id' => auth()->id() // Ensure your users are authenticated to use auth()->id()
            ]);
        } else {
            // Optionally, create the setting if it doesn't exist
            DB::table('settings')->insert([
                'key' => 'disable_registration',
                'value' => $status,
                'user_id' => auth()->id(), // Tracking the user ID
                'created_at' => now(), // Timestamp for creation
                'updated_at' => now() // Timestamp for the update
            ]);
        }

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('status', 'Registration status updated successfully.');
    }

    public function showSettings()
    {
        // Assuming 'disable_registration' is stored as 'true' or 'false' string.
        $registrationSetting = DB::table('settings')->where('key', 'disable_registration')->value('value');

        // Convert to boolean for JavaScript
        $isRegistrationDisabled = $registrationSetting === 'true' ? true : false;

        // Pass the status to the view
        return view('admin.settings', ['isRegistrationDisabled' => $isRegistrationDisabled]);
    }
}
