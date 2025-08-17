<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DietTypeRequest;
use App\Models\DietTypeModel;
use Illuminate\Http\Request;
use App\Models\MealModel;

class DietTypeController extends Controller
{
    // Hiển thị danh sách
    public function index(Request $request)
    {
        $query = DietTypeModel::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $dietTypes = $query->orderByDesc('id')->paginate(10);

        return view('Admin.diettypes.index', [
            'dietTypes' => $dietTypes,
        ]);
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('Admin.diettypes.create');
    }

    // Lưu bản ghi mới
    public function store(DietTypeRequest $request)
    {
        DietTypeModel::create([
            'name' => $request->name
        ]);

        return redirect()->route('diettypes.index')->with('success', 'Thêm mới thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $diet = DietTypeModel::with('meals')->findOrFail($id);
        $meals = MealModel::all(); // lấy danh sách tất cả món ăn
        return view('Admin.diettypes.edit', [
            'diet' => $diet,
            'meals' => $meals
        ]);
    }

    // Cập nhật bản ghi
    public function update(DietTypeRequest $request, $id)
    {
        $dietType = DietTypeModel::findOrFail($id);
        $dietType->update([
            'name' => $request->name
        ]);
        // Cập nhật mối quan hệ với các món ăn
        // Cập nhật lại quan hệ món ăn
        // 1. Xóa hết meal cũ (set diettype_id = null)
        $dietType->meals()->update(['diet_type_id' => null]);

        // 2. Gán lại meal mới nếu có chọn
        if ($request->has('meals')) {
            MealModel::whereIn('id', $request->meals)
                ->update(['diet_type_id' => $dietType->id]);
        }

        return redirect()->route('diettypes.index')->with('success', 'Cập nhật thành công!');
    }

    // Xóa bản ghi (dùng GET)
    public function destroy($id)
    {
        $dietType = DietTypeModel::findOrFail($id);
        $dietType->delete();

        return redirect()->route('diettypes.index')->with('success', 'Đã xóa thành công!');
    }

    // Xem chi tiết
    public function show($id)
    {
        $diet = DietTypeModel::with('meals')->findOrFail($id);
        return view('Admin.diettypes.show', [
            'diet' => $diet
        ]);
    }
}
