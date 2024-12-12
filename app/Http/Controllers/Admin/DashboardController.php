<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Refund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //Lấy danh sách năm có dữ liệu đơn hàng
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Lấy năm được chọn, nếu không chọn thì mặc định là năm hiện tại
        $selectedYear = request('year', Carbon::now()->year);
        // $selectedDay = request('day', null);

        // thời gian bắt đầu và kết thúc
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Điều kiện lọc ngày
        $filterByDate = function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }
        };
        // Tổng số người dùng
        $totalUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->count();

        // người dùng mới 
        $oneWeekAgo = Carbon::now()->subWeek()->toDateTimeString();
        $now = Carbon::now()->toDateTimeString();
        // dd($now);
        $newUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })
            ->where('created_at', '>=', $oneWeekAgo)
            ->where('created_at', '<=', $now)
            ->count();

        // Tổng doanh thu
        $totalCompleted = Order::where('status', 'COMPLETED')
            ->where($filterByDate)
            ->sum('total_amount');
        // Tổng giá trị hoàn hàng (dựa trên refund_items và status là 'APPROVED')
        $totalRefunds = Refund::where($filterByDate)
            ->with(['refundItem.productVariant.product'])  // Tải quan hệ refundItem và productVariant
            ->get()  // Lấy tất cả các refund
            ->sum(function ($refund) {
                // Tính tổng giá trị hoàn hàng cho mỗi đơn hoàn
                return $refund->refundItem->filter(function ($item) {
                    return $item->status == 'APPROVED';  // Lọc ra các item có trạng thái APPROVED
                })->sum(function ($item) {
                    // Tính giá trị của mỗi item hoàn hàng
                    return $item->quantity * $item->productVariant->price;
                });
            });
        $totalRevenue = $totalCompleted - $totalRefunds;

        // Tổng số đơn hàng
        $totalOrders = Order::where($filterByDate)->count();
        // Trạng thái đơn hàng
        $completedOrders = Order::where('status', 'COMPLETED')->where($filterByDate)->count();
        $pendingOrders = Order::where('status', 'PENDING')->where($filterByDate)->count();
        $deliveringOrders = Order::where('status', 'DELIVERING')->where($filterByDate)->count();
        $shippedOrders = Order::where('status', 'SHIPPED')->where($filterByDate)->count();
        $cancelledOrders = Order::where('status', 'CANCELED')->where($filterByDate)->count();
        // Đếm số đơn hàng có status là "REFUND" hoàn trả
        $refundOrders = Refund::where($filterByDate)->count();

        // Tính phần trăm đơn hàng hoàn thành thành công
        $successRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // Tính tổng số lượng (quantity) của tất cả các biến thể sản phẩm
        $totalQuantity = ProductVariant::where($filterByDate)->sum('quantity');
        // Tính tổng số lượng đã bán (sold) của tất cả các biến thể sản phẩm
        $totalSold = ProductVariant::where($filterByDate)->sum('sold');
        // Tồn kho
        $totalProduct = $totalQuantity - $totalSold;

        // Tổng số bài viết
        $totalArticles = Article::where($filterByDate)->count();

        // Lấy dữ liệu sản phẩm
        $salesData = Product::with(['productVariants'])->get();
        // Tính tổng số lượng bán của từng sản phẩm
        $processedData = $salesData->map(function ($product) {
            return [
                'code' => $product->code, // Mã sản phẩm
                'name' => $product->name, // Tên sản phẩm
                'sold' => $product->productVariants->sum('sold') // Tổng số lượng bán
            ];
        });
        // Lấy 15 sản phẩm bán nhiều nhất
        $topProducts = $processedData->sortByDesc('sold')->take(15);

        // Tách dữ liệu để truyền vào biểu đồ
        $codes = $topProducts->pluck('code'); // Mã sản phẩm
        $labels = $topProducts->pluck('name'); // Tên sản phẩm
        $data = $topProducts->pluck('sold'); // Số lượng bán

        // Lấy dữ liệu doanh thu của năm được chọn
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_revenue')
            ->where('status', 'COMPLETED')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // Lấy giá trị hoàn hàng theo tháng
        $monthlyRefunds = Refund::selectRaw('MONTH(refunds.created_at) as month, SUM(refund_items.quantity * product_variants.price) as total_refund')
            ->join('refund_items', 'refunds.id', '=', 'refund_items.refund_id')
            ->join('product_variants', 'refund_items.product_variant_id', '=', 'product_variants.id')
            ->whereYear('refunds.created_at', $selectedYear)
            ->where('refund_items.status', 'APPROVED')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $labelsMonthlyRevenue = [];
        $dataMonthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $labelsMonthlyRevenue[] = "Tháng $i";
            $dataMonthlyRevenue[] = 0;
        }

        // Cập nhật doanh thu theo tháng sau khi trừ giá trị hoàn hàng
        foreach ($monthlyRevenue as $revenue) {
            // Tìm giá trị hoàn hàng của tháng này
            $refundAmount = $monthlyRefunds->firstWhere('month', $revenue->month)->total_refund ?? 0;

            // Tính doanh thu sau khi trừ hoàn hàng
            $dataMonthlyRevenue[$revenue->month - 1] = $revenue->total_revenue - $refundAmount;
        }

        // Tính doanh thu trong ngày hiện tại
        $todayRevenue = Order::selectRaw('SUM(total_amount) as total_revenue')
            ->where('status', 'COMPLETED')
            ->whereDate('created_at', Carbon::today()) // Lọc theo ngày hiện tại
            ->first();

        $todayRefunds = Refund::whereDate('created_at', Carbon::today()) // Lọc theo ngày hiện tại
            ->with(['refundItem.productVariant.product'])  // Tải quan hệ refundItem và productVariant
            ->get()  // Lấy tất cả các refund
            ->sum(function ($refund) {
                // Tính tổng giá trị hoàn hàng cho mỗi đơn hoàn
                return $refund->refundItem->filter(function ($item) {
                    return $item->status == 'APPROVED';  // Lọc ra các item có trạng thái APPROVED
                })->sum(function ($item) {
                    // Tính giá trị của mỗi item hoàn hàng
                    return $item->quantity * $item->productVariant->price;
                });
            });
        // Kiểm tra xem có doanh thu hay không, nếu không thì giá trị sẽ là 0
        $totalTodayRevenue = $todayRevenue ? $todayRevenue->total_revenue - $todayRefunds : 0;

        // Đếm feedback
        $feedbackCount = Feedback::whereNull('parent_feedback_id')->where($filterByDate)->count();


        // Sản phẩm hết hàng
        $totalOutOfStockProducts = Product::with('productVariants')
            ->get() // Lấy tất cả sản phẩm
            ->filter(function ($product) {
                // Tính tổng số lượng của tất cả biến thể của sản phẩm
                $totalQuantity = $product->productVariants->sum('quantity');
                // Kiểm tra nếu tổng số lượng = 0, thì sản phẩm này hết hàng
                return $totalQuantity == 0;
            })
            ->count();


        // thống kê từng ngày trong tháng
        // Thống kê từng ngày trong tháng
        $selectedDayliMonth = request()->query('daily_month', now()->month);
        $selectedDayliYear = request()->query('daily_year', now()->year);

        // Lấy danh sách ngày trong tháng đã chọn
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedDayliMonth, $selectedDayliYear);
        $labelsDailyRevenue = range(1, $daysInMonth);

        // Lấy dữ liệu doanh thu theo ngày, bao gồm cả phần giảm trừ hoàn tiền
        $dataDailyRevenue = [];

        foreach ($labelsDailyRevenue as $day) {
            $date = sprintf('%04d-%02d-%02d', $selectedDayliYear, $selectedDayliMonth, $day);

            // Tính doanh thu hoàn tất trong ngày
            $dailyRevenue = DB::table('orders')
                ->where('status', 'COMPLETED') // Chỉ tính đơn đã hoàn thành
                ->whereDate('created_at', $date)
                ->sum('total_amount');

            // Tính hoàn tiền trong ngày
            $dailyRefunds = Refund::whereDate('created_at', $date)
                ->with(['refundItem.productVariant.product']) // Load các quan hệ cần thiết
                ->get()
                ->sum(function ($refund) {
                    // Tính tổng giá trị hoàn tiền trong mỗi refund
                    return $refund->refundItem->filter(function ($item) {
                        return $item->status == 'APPROVED'; // Chỉ lấy các mục hoàn tiền đã được duyệt
                    })->sum(function ($item) {
                        // Tính giá trị của từng item hoàn tiền
                        return $item->quantity * $item->productVariant->price;
                    });
                });

            // Tổng doanh thu trong ngày = Doanh thu - Giá trị hoàn tiền
            $dataDailyRevenue[] = $dailyRevenue - $dailyRefunds;
        }

        return view(
            'admin.pages.dashboard.index',
            compact(
                'availableYears',
                'selectedYear',
                'labelsDailyRevenue',
                'dataDailyRevenue',
                'selectedDayliMonth',
                'selectedDayliYear',
                'totalUsers',
                'totalRevenue',
                'completedOrders',
                'pendingOrders',
                'deliveringOrders',
                'shippedOrders',
                'cancelledOrders',
                'refundOrders',
                'newUsers',
                'successRate',
                'totalOrders',
                'totalProduct',
                'totalArticles',
                'feedbackCount',
                'labels',
                'codes',
                'data',
                'labelsMonthlyRevenue',
                'dataMonthlyRevenue',
                'totalTodayRevenue',
                'totalOutOfStockProducts'
            )
        );
    }
}
