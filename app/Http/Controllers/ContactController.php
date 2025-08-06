<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ContactController extends Controller
{
    protected $controllerName = "contact";
    protected $pathViewController = "admin.contacts.";

    public function __construct()
    {
        View::share('controller', $this->controllerName);
    }


    public function index()
    {
        $items = ContactModel::orderBy('id', 'desc')->get();

        return view($this->pathViewController . "index", [
            'items' => $items
        ]);
    }

    public function detail($id)
    {
        $selectedItem = ContactModel::find($id);
        $items = ContactModel::orderBy('id', 'desc')->get();

        if (!$selectedItem) {
            return redirect()->route('contact.index')->withErrors(['msg' => 'Liên hệ không tồn tại']);
        }

        return view($this->pathViewController . "index", [
            'items' => $items,
            'selectedItem' => $selectedItem
        ]);
    }

    public function delete($id)
    {
        $item = ContactModel::find($id);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('contact.index')->with('success', 'Đã xóa liên hệ thành công');
    }
}
