<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType; 
use App\Models\User;
use App\Models\PackagePlan;


class IndexController extends Controller
{
    public function PropertyDetails($id,$slug){
        $property = Property::findorFail($id);
        $amenities = $property->amenities_id;
        $property_amen = explode(',',$amenities);
        $facility = Facility::where('property_id',$id)->get();
        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id',$type_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.property.property_details',compact('property','property_amen','facility','relatedProperty'));
    }
    //
}
