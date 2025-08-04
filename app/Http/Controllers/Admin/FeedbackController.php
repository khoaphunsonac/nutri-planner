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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // $feedbacks = FeedbackModel::all();
         $feedbacks = $query->orderBy('created_at', 'desc')->get();
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
        return view('admin.feedbacks.show',[
            'feedback' => $feedback,
        ]); 
      
    }

    
    

    // Xóa phản hồi
    public function destroy($id)
    {
        $feedback = FeedbackModel::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Đã xóa phản hồi.');
    }
    
}
