<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Order;
use App\Coupon;
use App\Product;
use App\Category;
use App\Attribute;
use App\Inventory;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

    // Dashboard - URL: /admin
    public function index()
    {
        // Stats
        $stats = [];

        // Stats - Orders - Processing
        $stats['orders']['processing'] = Order::where('status', 'processing')->count();

        // Stats - Orders - Processing - Total
        $stats['orders']['processing_total'] = Order::where('status', 'processing')->sum('total');

        // Stats - Orders - Last Month
        $stats['orders']['last_month'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->subMonth(1)->startOfMonth())
            ->where('created_at', '<=', Carbon::now(config('custom.timezone'))->subMonth(1)->endOfMonth())->count();

        // Stats - Orders - Last Month - Total
        $stats['orders']['last_month_total'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->subMonth(1)->startOfMonth())
            ->where('created_at', '<=', Carbon::now(config('custom.timezone'))->subMonth(1)->endOfMonth())->sum('total');

        // Stats - Orders - Month To Date
        $stats['orders']['month_to_date'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->startOfMonth())->count();

        // Stats - Orders - Month To Date - Total
        $stats['orders']['month_to_date_total'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->startOfMonth())->sum('total');

        // Stats - Orders - Last Year
        $stats['orders']['last_year'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->subYear(1)->startOfYear())
            ->where('created_at', '<=', Carbon::now(config('custom.timezone'))->subYear(1)->endOfYear())->count();

        // Stats - Orders - Last Year - Total
        $stats['orders']['last_year_total'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->subYear(1)->startOfYear())
            ->where('created_at', '<=', Carbon::now(config('custom.timezone'))->subYear(1)->endOfYear())->sum('total');

        // Stats - Orders - Year To Date
        $stats['orders']['year_to_date'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->startOfYear())->count();

        // Stats - Orders - Year To Date - Total
        $stats['orders']['year_to_date_total'] = Order::where('created_at', '>=', Carbon::now(config('custom.timezone'))->startOfYear())->sum('total');

        // Stats - Orders - Lifetime - Count
        $stats['orders']['lifetime'] = Order::count();

        // Stats - Orders - Lifetime - Total
        $stats['orders']['lifetime_total'] = Order::sum('total');

        // Stats - Orders - Last User
        $stats['orders']['last_order'] = Order::orderBy('created_at', 'desc')->first();

        // Stats - Store - Categories
        $stats['store']['categories'] = Category::count();

        // Stats - Store - Attributes
        $stats['store']['attributes'] = Attribute::count();

        // Stats - Store - Products
        $stats['store']['products'] = Product::count();

        // Stats - Store - Inventory
        $stats['store']['inventory'] = Inventory::count();

        // Stats - Store - Out of Stock
        $stats['store']['out_of_stock'] = Inventory::outOfStock()->count();

        // Stats - Coupons
        $stats['store']['coupons'] = Coupon::count();

        // Stats - Users - Admins
        $stats['users']['admins'] = User::where('type', 'admin')->count();

        // Stats - Users - Customers
        $stats['users']['customers'] = User::where('type', 'user')->count();

        // Stats - Users
        $stats['users']['total'] = User::count();

        // Stats - Users - Last User
        $stats['users']['last_user'] = User::orderBy('created_at', 'desc')->first();

        return view('admin.index', compact('stats'));
    }

}
