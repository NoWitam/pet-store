<?php

namespace App\Enums;

enum PetStatus : string
{
  case AVAILABLE = "available";
  case PENDING = "pending";
  case SOLD = "sold";

  public static function labels(): array
  {
    $labels = [];

    foreach (self::cases() as $status)
    {
      $labels[$status->value] = $status->label();
    }

    return $labels;
  }
  
  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  } 

  public function label(): string
  {
    return match($this)
    {
      self::AVAILABLE => 'Dostepne',
      self::PENDING => 'Oczekujace',
      self::SOLD => 'Sprzedane',
    };
  }
}