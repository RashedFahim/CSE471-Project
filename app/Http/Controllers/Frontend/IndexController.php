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
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyMessage;
use Carbon\Carbon;

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

    public function PropertyMessage(Request $request){
        $pid = $request->property_id;
        $aid = $request->agent_id;

        if (Auth::check()){
        
        PropertyMessage::insert([
            'user_id' => Auth::user()->id,
            'agent_id' => $aid,
            'property_id' => $pid,
            'msg_name' => $request->msg_name,
            'msg_email' => $request->msg_email,
            'msg_phone' => $request->msg_phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Message Sent Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

        } else {
            $notification = array(
            'message' => 'Please Login First',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
        }
    }
}
