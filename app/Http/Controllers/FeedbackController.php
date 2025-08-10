<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FeedbackModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{


    // Form gửi feedback
    public function create()
    {
        return view('site.feedbacks.create');
    }

    // Lưu feedback
    public function store(FeedbackRequest $request)
    {

        FeedbackModel::create([
            'account_id' => Auth::id(),
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()->route('site.feedbacks.create')->with('success', 'Cảm ơn bạn đã gửi phản hồi!');
    }
}
