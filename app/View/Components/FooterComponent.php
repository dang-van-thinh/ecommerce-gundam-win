<?php

namespace App\View\Components;

use App\Models\CategoryArticle;
use App\Models\CategoryProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterComponent extends Component
{
    public $categoryProduct;
    public $categoryArticle;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categoryProduct = CategoryProduct::all();
        $this->categoryArticle = CategoryArticle::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // dd($this->categoryProduct);
        return view('client.layouts.partials.header.header-menu', [
            'categoryProduct' => $this->categoryProduct,
            'categoryArticle' => $this->categoryArticle
        ]);
    }
}
