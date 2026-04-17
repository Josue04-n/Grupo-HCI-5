<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    // Esto cambia el nombre en el menú lateral izquierdo
    protected static ?string $navigationLabel = 'Dashboard';

    // Esto cambia el título grande de arriba
    protected ?string $heading = 'Dashboard';
}