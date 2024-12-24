<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\PackagePlan;

class AgentPropertyController extends Controller
{
    public function AgentAllProperty(){
        $id = Auth::user()->id;
        $property = Property::where('agent_id',$id)->latest()->get();
        return view('agent.property.all_property',compact('property'));

    } // End Method   

    public function AgentAddProperty(){
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $id = Auth::user()->id;
        $property = User::where('role','agent')->where('id',$id)->first();
        $pcount = $property->credit;
        // dd($pcount);
        if ($pcount == 1 || $pcount == 7) {
           return redirect()->route('buy.package');
        }else{
            return view('agent.property.add_property',compact('propertytype','amenities'));
        }
       
    }// End Method 

    public function AgentStoreProperty(Request $request){
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        // dd($amenites);

        $pcode = IdGenerator::generate(['table' => 'properties','field' => 'property_code','length' => 5, 'prefix' => 'PC' ]);


        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thambnail/'.$name_gen);
        $save_url = 'upload/property/thambnail/'.$name_gen;

        $property_id = Property::insertGetId([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),
            ]);

             /// Multiple Image Upload From Here ////

             $images = $request->file('multi_img');
             foreach($images as $img){

             $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
             Image::make($img)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
             $uploadPath = 'upload/property/multi-image/'.$make_name;

             MultiImage::insert([

                 'property_id' => $property_id,
                 'photo_name' => $uploadPath,
                 'created_at' => Carbon::now(), 

             ]); 
             } // End Foreach
             
              /// End Multiple Image Upload From Here ////

              ///Facilities Add From Here///
             $facilities = Count($request->facility_name);

             if (facilities != NULL){
                for ($i=0; $i < $facilities; $i++){
                    $fcount = new Facility();
                    $fcount->property_id = $property_id;
                    $fcount->facility_name = $request->facility_name[$id];
                    $fcount->distance = $request->distance[$id];
                    $fcount->save();
                }
             }


              ///End Facilities///
              User::where('id',$id)->update([
                'credit' => DB::raw('1 + '.$nid),
            ]);
              $notification = array(
                'message' => 'Property Inserted Successfully',
                'alert-type' => 'success'
              );
              return redirect()->route('agent.all.property')->with($notification);
 
    }// End Method 

    public function AgentEditProperty($id){
        $facilities = Facility::where('property_id', $id)->get(); 
        $property = Property::findOrFail($id);
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);
        $multiImage = MultiImage::where('property_id',$id)->get();
        $propertytype = PropertyType::latest()->get(); 
        $amenities = Amenities::latest()->get();
        return view('agent.property.edit_property', compact ('property','propertytype', 'amenities', 'property_ami','multiImage' ,'facilities'));
        }// End Method
    //

    public function BuyPackage(){

        return view('agent.package.buy_package');
    }// End Method  

    public function BuyBusinessPlan(){
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.business_plan',compact('data'));
    }// End Method 

    public function StoreBusinessPlan(Request $request){
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;
      PackagePlan::insert([
        'user_id' => $id,
        'package_name' => 'Business',
        'package_credits' => '3',
        'invoice' => 'ERS'.mt_rand(10000000,99999999),
        'package_amount' => '20',
        'created_at' => Carbon::now(), 
      ]);
        User::where('id',$id)->update([
            'credit' => DB::raw('3 + '.$nid),
        ]);
       $notification = array(
            'message' => 'You have purchase Basic Package Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('agent.all.property')->with($notification);  
    }// End Method 


    public function BuyProfessionalPlan(){
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.professional_plan',compact('data'));
    }// End Method  
     public function StoreProfessionalPlan(Request $request){
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;
      PackagePlan::insert([
        'user_id' => $id,
        'package_name' => 'Professional',
        'package_credits' => '10',
        'invoice' => 'ERS'.mt_rand(10000000,99999999),
        'package_amount' => '50',
        'created_at' => Carbon::now(), 
      ]);
        User::where('id',$id)->update([
            'credit' => DB::raw('10 + '.$nid),
        ]);
       $notification = array(
            'message' => 'You have purchase Professional Package Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('agent.all.property')->with($notification);  
    }// End Method 








} 









































































