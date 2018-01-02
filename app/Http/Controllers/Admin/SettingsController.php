<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Admin - Settings
     * URL: /admin/settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::orderBy('created_at', 'desc')->get();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Admin - Update Setting
     * URL: /admin/settings/{setting} (PUT)
     *
     * @param Request $request
     * @param $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $setting)
    {
        $data = $request->all();

        $setting->state = isset($data['state']);

        $result = $setting->save();

        if ($result) {
            return redirect(route('admin.settings.index'))->with('alert-success', 'The setting has been updated successfully.');
        } else {
            return back()->with('alert-danger', 'The setting cannot be updated, please try again or contact the administrator.');
        }
    }
}