<?php


namespace Modules\Ifillable\Support;

use Illuminate\Database\Eloquent\Collection;

class FieldCollection extends Collection
{

  /**
   * Relation used with transformers in Modules
   */
  public function mappedFields(): array
  {
    $translations = [];
    $attributes = [];
    $currentLocale = app()->getLocale();

    foreach ($this as $field) {
      $isMultilang = false;
      $fieldTitle = $field->title;

      foreach ($field->getAttributes() as $locale => $data) {
        if (is_array($data) && isset($data['value'])) {
          $translations[$locale][$fieldTitle] = $data['value'];
          $isMultilang = true;
        }
      }

      if ($isMultilang) {
        $attributes[$fieldTitle] =
          $translations[$currentLocale][$fieldTitle] ?? null;
      } else {
        $attributes[$fieldTitle] = $field->value;
      }
    }

    return array_merge($attributes, $translations);
  }
}
