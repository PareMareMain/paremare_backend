<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	use HasFactory;

	protected $fillable = ['name','amount', 'plan_type','status', 'description'];

	// protected $appends = ["plan"];

	// public function getPlanAttribute()
	// {
	// 	switch ($this->plan_type) {
	// 		case '1':
	// 			$plan = 'Daily';
	// 			break;
	// 		case '2':
	// 			$plan =  'Monthly';
	// 			break;
	// 		case '3':
	// 			$plan =   'Yearly';
	// 			break;

	// 		default:
	// 			$plan = 'Yearly';
	// 			break;
	// 	}
	// 	return $plan;
	// }
}
