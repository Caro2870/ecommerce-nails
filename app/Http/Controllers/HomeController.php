<?php

namespace App\Http\Controllers;

use App\Models\PortfolioPhoto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = site_settings_for_landing();

        $photos = PortfolioPhoto::query()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        if ($photos->isEmpty()) {
            $photos = PortfolioPhoto::query()->orderBy('sort_order')->take(6)->get();
        }

        return view('home', [
            'siteName' => $settings['site_name'],
            'address' => $settings['address'],
            'whatsAppUrl' => $this->buildWhatsAppUrl($settings['whatsapp_number']),
            'photos' => $photos,
        ]);
    }

    private function buildWhatsAppUrl(?string $raw): string
    {
        $number = preg_replace('/\D+/', '', $raw ?? '920236307');

        if ($number === '') {
            $number = '920236307';
        }

        if (! str_starts_with($number, '51')) {
            $number = '51'.$number;
        }

        return 'https://wa.me/'.$number.'?text='.rawurlencode('Hola quiero reservar una cita');
    }
}
