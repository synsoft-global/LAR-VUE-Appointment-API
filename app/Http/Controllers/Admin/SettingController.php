<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display all settings.
     *
     * This method is responsible for retrieving all settings from the database
     * and returning them as an associative array where the key is the setting
     * key and the value is the setting value. If no settings are found in the
     * database, it returns the default settings defined in the configuration.
     * 
     * @return array
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        if (! $settings) {
            return config('settings.default');
        }

        return $settings;
    }

    /**
     * Update application settings.
     *
     * This method is responsible for updating the application settings based on
     * the data provided in the request body. It expects the updated settings to
     * be passed in the request body with the keys 'app_name', 'date_format', and
     * 'pagination_limit'. It validates the input data and updates or creates the
     * corresponding settings in the database. It also flushes the settings cache
     * to ensure that the updated settings are immediately available. Upon successful
     * update, it returns a JSON response indicating success.
     * 
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $settings = request()->validate([
            'app_name' => ['required', 'string'],
            'date_format' => ['required', 'string'],
            'pagination_limit' => ['required', 'int', 'min:1', 'max:100'],
        ]);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }

        Cache::flush('settings');

        return response()->json(['success' => true]);
    }
}
