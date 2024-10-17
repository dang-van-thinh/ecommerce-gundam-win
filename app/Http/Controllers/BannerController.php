<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    // Danh sách tất cả các banners
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }

    // Hiển thị form tạo mới banner
    public function create()
    {
        return view('admin.banner.create');
    }

    // Lưu banner mới vào database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            'image_type' => 'required|in:header,content',
            'link' => 'required|nullable|url',
        ], [
            'title.required' => 'Không được để trống',
            'image.required' => 'Không được để trống hình ảnh',
            'link.required' => 'Không được để trống'
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banner', 'public'); // Save to public storage
            $validated['image_url'] = $path; // Store the path in DB
        }

        // Create the banner record
        Banner::create($validated);

        return redirect()->route('banner.index')->with('success', 'Banner added successfully');
    }
    // Hiển thị chi tiết banner
    public function show($id)
    {
        $banners = Banner::findOrFail($id);
        return view('admin.banner.show', compact('banners'));
    }

    // Hiển thị form chỉnh sửa banner
    public function edit($id)
    {
        $banners = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banners'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'image_url' => 'nullable|url',
            'image_type' => 'in:header,content',
            'link' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validating the uploaded image
        ]);
    
        $banners = Banner::findOrFail($id);
    
        // Handle the image upload
       
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('banner', 'public'); 
                $validated['image_url'] = $path; 
            } 
    
        // Update the banner with the validated data
        $banners->update($validated);
    
        return redirect()->route('banner.index')->with('success', 'Banner updated successfully');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banners = Banner::findOrFail($id);
        $banners->delete();

        return redirect()->route('banner.index')->with('success', 'Banner deleted successfully');
    }
}
?>