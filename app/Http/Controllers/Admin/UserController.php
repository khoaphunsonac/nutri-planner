<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealTypeModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MealTypeController extends Controller
{
    // GET /admin/meal_types
    public function index(Request $request)
    {
        $q    = $request->query('q');
        $from = $request->query('from');
        $to   = $request->query('to');

        $items = MealTypeModel::query()
            ->when($q,   fn ($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->when($from, fn ($qr) => $qr->whereDate('created_at', '>=', $from))
            ->when($to,   fn ($qr) => $qr->whereDate('created_at', '<=', $to))
            ->withCount('meals')              // dùng $it->meals_count trên list
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());     // giữ query khi chuyển trang

        return view('admin.meal_types.index', compact('items', 'q'));
    }

    // GET /admin/meal_types/create
    public function create()
    {
        return view('admin.meal_types.form', [
            'mode' => 'create',
            'item' => null,
        ]);
    }

    // POST /admin/meal_types/store
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:meal_type,name', // giữ đúng tên bảng bạn đang dùng
        ], [
            'name.required' => 'Không được bỏ trống',
            'name.max'      => 'Không được vượt quá 100 ký tự',
            'name.unique'   => 'Tên này đã tồn tại',
        ]);

        MealTypeModel::create($data);

        return redirect()->route('admin.meal_types.index')
            ->with('success', 'Tạo loại bữa ăn thành công.');
    }

    // GET /admin/meal_types/{id}
    public function show($id)
    {
        $item = MealTypeModel::withCount('meals')->findOrFail($id);

        // Danh sách món thuộc loại này + phân trang
        $relatedDishes = \App\Models\MealModel::where('meal_type_id', $item->id)
            ->orderByDesc('id')
            ->paginate(10);

        $relatedCount = $item->meals_count; // hoặc $relatedDishes->total()

        return view('admin.meal_types.show', compact('item', 'relatedDishes', 'relatedCount'));
    }

    // GET /admin/meal_types/{id}/edit
    public function edit($id)
    {
        $item = MealTypeModel::findOrFail($id);
        return view('admin.meal_types.form', [
            'mode' => 'edit',
            'item' => $item,
        ]);
    }

    // POST /admin/meal_types/{id}/update
    public function update(Request $request, $id)
    {
        $item = MealTypeModel::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:100|unique:meal_type,name', // giữ nguyên rule theo bảng hiện tại
        ], [
            'name.required' => 'Không được bỏ trống',
            'name.max'      => 'Không được vượt quá 100 ký tự',
            'name.unique'   => 'Tên này đã tồn tại',
        ]);

        $item->update($data);

        return redirect()->route('admin.meal_types.index')
            ->with('success', 'Cập nhật thành công.');
    }

    // GET /admin/meal_types/{id}/delete
    public function delete($id)
    {
        $item = MealTypeModel::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.meal_types.index')
            ->with('success', 'Đã xoá.');
    }
}
