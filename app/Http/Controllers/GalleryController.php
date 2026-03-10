<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PortfolioPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $settings = site_settings_for_landing();
        $categories = Category::query()->orderBy('sort_order')->get(['id', 'name', 'slug']);
        $activeSlug = request('cat');

        if (! $activeSlug) {
            $activeSlug = $categories->first()?->slug;
        }

        $photos = PortfolioPhoto::query()
            ->with('category')
            ->when($activeSlug, function ($query, $slug) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $slug));
            })
            ->orderBy('sort_order')
            ->paginate(24)
            ->withQueryString();

        return view('gallery', [
            'siteName' => $settings['site_name'],
            'categories' => $categories,
            'activeCategorySlug' => $activeSlug,
            'photos' => $photos,
        ]);
    }

    public function api(): JsonResponse
    {
        $activeSlug = request('cat');
        $photos = PortfolioPhoto::query()
            ->with('category')
            ->when($activeSlug, function ($query, $slug) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $slug));
            })
            ->orderBy('sort_order')
            ->paginate(24)
            ->withQueryString();

        return response()->json($photos);
    }
}
