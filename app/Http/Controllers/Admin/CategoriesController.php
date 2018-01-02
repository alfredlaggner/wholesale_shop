<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Admin - Store Category
     * URL: /admin/categories (POST)
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Validation
        $this->validate($request, [
            'name' => 'required|min:2|max:45|unique:categories',
            'uri' => 'required|min:2|max:45|alpha_dash|unique:categories',
        ]);

        if ($data['parent_id'] == 0) {
            unset($data['parent_id']);
        }

        $createdCategory = Category::create($data);

        if ($createdCategory) {
            cache()->forget('categories');

            return redirect(route('admin.categories.index'))->with('alert-success', 'The category has been added successfully.');
        } else {
            return back()->with('alert-danger', 'The category cannot be added, please try again or contact the administrator.');
        }
    }

    /**
     * Admin - Update category
     * URL: /admin/categories/{category} (PUT)
     *
     * @param Request $request
     * @param $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $category)
    {
        $data = $request->all();

        // Validation
        $this->validate($request, [
            'name' => 'required|min:2|max:45|unique:categories,name,' .  $category['id'],
            'uri' => 'required|min:2|max:45|alpha_dash|unique:categories,uri,' .  $category['id'],
        ]);

        if ($data['parent_id'] == $category['id']) {
            return back()->with('alert-danger', 'The category cannot be under itself.');
        }

        // Sanitizing data
        $data['menu'] = isset($data['menu']);

        foreach ([
                    'name',
                    'uri',
                    'parent_id',
                    'order',
                    'menu'
                 ] as $field) {
            if ($data[$field] != $category->{$field}) {
                $category->{$field} = $data[$field];
            }
        }

        $result = $category->save();

        if ($result) {
            cache()->forget('categories');

            return redirect(route('admin.categories.show', $category['id']))->with('alert-success', 'The category has been updated successfully.');
        } else {
            return back()->with('alert-danger', 'The category cannot be updated, please try again or contact the administrator.');
        }
    }

    /**
     * Admin - Remove Category
     * URL: /admin/categories/{category} (DELETE)
     *
     * @param $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($category)
    {
        // The Category must not have any associated Products to be deleted
        if ($category->products() && $category->products()->count() > 0) {
            return back()->with('alert-danger', 'This category cannot be removed because there are currently ' . $category->products()->count() . ' products associated with it. Please remove the products first.');
        }
        // The Category must not have any associated Sub-categories to be deleted
        if ($category->children() && $category->children()->count() > 0) {
            return back()->with('alert-danger', 'This category cannot be removed because there are currently ' . $category->children()->count() . ' sub-categories associated with it. Please remove the products first.');
        }
        else {
            $category->delete();

            cache()->forget('categories');

            return redirect(route('admin.categories.index'))->with('alert-success', 'The category has been removed successfully.');
        }
    }
}