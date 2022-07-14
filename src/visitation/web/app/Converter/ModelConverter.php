<?php

namespace App\Converter;

class ModelConverter 
{
   public static function to_visitation_rowmanager($models) {
     
      $new_models = [];
      foreach ($models as $key => $model) {
         $new_model = static::to_visitation_entry($model);
         $new_models[] = $new_model;
      }
      return $new_models;
   }

   public static function to_visitation_entry($model) {
      $new_model = new \stdClass;
      $new_model->id = $model->id;
      $new_model->date = $model->date;
      $new_model->remarks = $model->remarks;
      $new_model->visitation_details = static::to_visitation_detail_rowmanager($model->visitation_details); 
      return $new_model;
   }

   public static function to_visitation_detail_rowmanager($models) {
      $new_models = [];
      foreach ($models as $model) {
         $new_model = static::to_visitation_detail_entry($model);
         $new_models[] = $new_model;
      }
      return $new_models;
   }

   public static function to_visitation_detail_entry($model) {
      $new_model = new \stdClass;
      $new_model->id = $model->id;
      $new_model->cm_id = $model->cm_id;
      $new_model->name = $model->contract->account_name;
      $new_model->date_visited = $model->date_visited;
      $new_model->account_no = $model->contract->account_number; 
      $new_model->address = $model->contract->home_address_1;
      $new_model->right_party = $model->right_party !== null ? static::to_visitation_right_party_entry($model->right_party): false;
      $new_model->third_party = $model->third_party !== null ? static::to_visitation_third_party_entry($model->third_party): false;
      $new_model->negative = $model->negative !== null ? static::to_visitation_negative_party_entry($model->negative): false;
      $new_model->is_visited = $new_model->right_party || $new_model->third_party || $new_model->negative;
      $new_model->seq = $model->seq;
      return $new_model;
   }

   public static function to_visitation_right_party_entry($model) {
      $new_model = $model;
      return $new_model;
   }

   public static function to_visitation_third_party_entry($model) {
      $new_model = $model;
      return $new_model;
   }

   public static function to_visitation_negative_party_entry($model) {
      $new_model = $model;
      return $new_model;
   }
}