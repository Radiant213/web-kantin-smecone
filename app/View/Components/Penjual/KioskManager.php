<?php

namespace App\View\Components\Penjual;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KioskManager extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = auth()->user();
        $kiosk = \App\Models\Kiosk::where('user_id', $user->id)->first();
        $pendingApplication = \App\Models\KioskApplication::where('user_id', $user->id)->where('status', 'pending')->first();

        // Kiosks that do not have an owner
        $availableKiosks = \App\Models\Kiosk::whereNull('user_id')->get();

        return view('components.penjual.kiosk-manager', compact('kiosk', 'pendingApplication', 'availableKiosks'));
    }
}
