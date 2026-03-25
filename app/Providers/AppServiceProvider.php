<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): HtmlString => new HtmlString('
                <script>
                  (function(_u,s){
                    var s=document.createElement("script");
                    s.setAttribute("data-account","xJl5DgXWGL");
                    s.setAttribute("src","https://cdn.userway.org/widget.js");
                    /* Posición 1 es Bottom-Left */
                    s.setAttribute("data-position","1"); 
                    document.body.appendChild(s);
                  })();
                </script>
                
                <style>
                    /* FORZAR POSICIÓN Y VISIBILIDAD TOTAL */
                    #userwayAccessibilityWidget, 
                    .userway_buttons_wrapper,
                    .u-btn {
                        left: 80px !important;    /* Lo alejamos un poco más de la orilla para que no choque con el menú lateral */
                        right: auto !important;
                        bottom: 20px !important;
                        top: auto !important;
                        position: fixed !important; /* Asegura que flote sobre todo */
                        z-index: 99999 !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }

                    /* Evitar que el logo se vea cortado por el margen lateral de la página */
                    body.fi-body {
                        position: relative !important;
                    }

                    /* Ajuste extra para la cabecera (Topbar) */
                    .fi-topbar-actions {
                        margin-right: 2rem !important;
                    }
                </style>
            '),
        );
    }
}