<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ImageArticle\CreateImageArticleRequest; // Đảm bảo đúng namespace với chữ hoa
use Illuminate\Support\Facades\Storage;
use App\Models\ImageArticle;
use App\Http\Controllers\Controller;
use Flasher\Prime\Notification\NotificationInterface;

class ImageArticleController extends Controller
{
    public function index()
    {
        $imageArticle = ImageArticle::latest('id')->paginate(5);
        // dd($imageArticle);
        return view('admin.pages.imagearticle.index', ['listImageArticle' => $imageArticle]);
    }

    public function create()
    {
        return view('admin.pages.imagearticle.create');
    }

    public function store(CreateImageArticleRequest $request)
    {
        if ($request->hasFile('images')) {
            $imagePaths = [];
        
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/imagearticle', 'public');
                $imagePaths[] = $path;
            }
        
            foreach ($imagePaths as $path) {
                ImageArticle::create(['image_url' => $path]);
            }
        
            // Lấy danh sách hình ảnh đã cập nhật
            $listImageArticle = ImageArticle::latest('id')->get();
        
            return response()->json([
                'success' => true,
                'images' => $listImageArticle,
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'No images uploaded'], 400);
    }
    
    
    public function show()
    {
        $imageArticle = ImageArticle::latest('id')->paginate(5);
        // dd($imageArticle);
        return view('admin.pages.imagearticle.show', ['listImageArticle' => $imageArticle]);
    }


    public function destroy(string $id)
    {
        $imageArticle = ImageArticle::find($id);
        Storage::disk('public')->delete($imageArticle->image_url);
        $imageArticle->delete();
        toastr("Chúc mừng bạn đã xóa thành công", NotificationInterface::SUCCESS, "Xóa thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("imagearticle.index");
    }
}
