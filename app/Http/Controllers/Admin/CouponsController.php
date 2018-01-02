<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    /**
     * Admin - Coupons
     * URL: /admin/coupons
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Admin - Create Coupon
     * URL: /admin/coupons/create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $products = Product::orderBy('category_id')->orderBy('order')->get();

        return view('admin.coupons.create', compact('products'));
    }

    /**
     * Admin - Store Coupon
     * URL: /admin/coupons (POST)
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Validation
        $this->validate($request, [
            'code' => 'required|alpha_dash|min:3|unique:coupons',
            'discount_percentage' => 'required_if:type,percentage',
            'discount_amount' => 'required_if:type,amount',
            'limit' => 'required_with:limited'
        ]);

        // Sanitize inputs
        $data['limited'] = isset($data['limited']);

        if (!empty($data['start'])) {
            $data['start'] = Carbon::createFromFormat('m/d/Y g:i A', $data['start'], config('custom.timezone'))->setTimezone(config('app.timezone'));
        } else {
            unset($data['start']);
        }

        if (!empty($data['end'])) {
            $data['end'] = Carbon::createFromFormat('m/d/Y g:i A', $data['end'], config('custom.timezone'))->setTimezone(config('app.timezone'));
        } else {
            unset($data['end']);
        }

        $createdCoupon = Coupon::create($data);

        if ($createdCoupon) {
            // Attach applicable Products (if given)
            if (!empty($data['products'])) {
                $createdCoupon->products()->attach($data['products']);
            }

            return redirect(route('admin.coupons.index'))->with('alert-success', 'The coupon has been added successfully.');
        } else {
            return back()->with('alert-danger', 'The coupon cannot be added, please try again or contact the administrator.');
        }
    }

    /**
     * Admin - Show/Edit Coupon
     * URL: /admin/coupons/{coupon}
     *
     * @param $coupon
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($coupon)
    {
        $products = Product::orderBy('category_id')->orderBy('order')->get();

        return view('admin.coupons.show', compact('coupon', 'products'));
    }

    /**
     * Admin - Update Coupon
     * URL: /admin/coupons/{coupon} (PUT)
     *
     * @param Request $request
     * @param $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $coupon)
    {
        $data = $request->all();

        // Validation
        $this->validate($request, [
            'code' => 'required|alpha_dash|min:3|unique:coupons,code,' . $coupon['id'] . ',id',
            'discount_percentage' => 'required_if:type,percentage',
            'discount_amount' => 'required_if:type,amount',
            'limit' => 'required_with:limited'
        ]);

        // Sanitize inputs
        $data['limited'] = isset($data['limited']);

        $data['active'] = isset($data['active']);

        // Empty the current 'discount_amount' if a new 'discount_percentage' is given
        if (!empty($data['discount_percentage']) && !empty($coupon['discount_amount'])) {
            $coupon->{'discount_amount'} = null;
        }

        // Empty the current 'discount_percentage' if a new 'discount_amount' is given
        if (!empty($data['discount_amount']) && !empty($coupon['discount_percentage'])) {
            $coupon->{'discount_percentage'} = null;
        }

        if (!empty($data['start'])) {
            $data['start'] = Carbon::createFromFormat('m/d/Y g:i A', $data['start'], config('custom.timezone'))->timezone(config('app.timezone'));
        } else {
            unset($data['start']);
        }

        if (!empty($data['end'])) {
            $data['end'] = Carbon::createFromFormat('m/d/Y g:i A', $data['end'], config('custom.timezone'))->timezone(config('app.timezone'));
        } else {
            unset($data['end']);
        }

        foreach ([
                     'code',
                     'type',
                     'discount_percentage',
                     'discount_amount',
                     'shipping',
                     'limited',
                     'limit',
                     'start',
                     'end',
                     'active'
                 ] as $field) {
            if (isset($data[$field]) && $data[$field] != $coupon->{$field}) {
                $coupon->{$field} = $data[$field];
            }
        }

        $result = $coupon->save();

        if ($result) {
            // Update applicable Products
            $coupon->products()->sync(!empty($data['products']) ? $data['products'] : []);

            return redirect(route('admin.coupons.index'))->with('alert-success', 'The coupon has been updated successfully.');
        } else {
            return back()->with('alert-danger', 'The coupon cannot be updated, please try again or contact the administrator.');
        }
    }

    /**
     * Admin - Remove Coupon
     * URL: /admin/coupons/{coupon} (DELETE)
     *
     * @param $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($coupon)
    {
        $coupon->delete();

        return redirect(route('admin.coupons.index'))->with('alert-success', 'The coupon has been removed successfully.');
    }
}