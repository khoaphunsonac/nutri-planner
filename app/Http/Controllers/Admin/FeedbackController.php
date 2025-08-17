<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedbackModel;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = FeedbackModel::with('account');

        if ($request->filled('search')) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Lọc theo khoảng ngày
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . " 00:00:00",
                $request->date_to . " 23:59:59"
            ]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // $feedbacks = FeedbackModel::all();
        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(10);
        // return $feedbacks;
        return view('Admin.feedbacks.index', [
            'feedbacks' => $feedbacks,
            'search' => $request->search,
            'status' => $request->status,
        ]);
    }

    // Xem chi tiết phản hồi
    public function show($id)
    {
        $feedback = FeedbackModel::with('account')->findOrFail($id);
        return view('Admin.feedbacks.show', [
            'feedback' => $feedback,
        ]);
    }




    // Xóa phản hồi
    public function destroy($id)
    {
        $feedback = FeedbackModel::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Đã xóa phản hồi.');
    }
}
