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
use Barryvdh\DomPDF\Facade\Pdf;


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
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'status' => 1,
            'created_at' => Carbon::now(), 
        ]);
         /// Facilities Add From Here ////
        $facilities = Count($request->facility_name);
        if ($facilities != NULL) {
           for ($i=0; $i < $facilities; $i++) { 
               $fcount = new Facility();
               $fcount->property_id = $property_id;
               $fcount->facility_name = $request->facility_name[$i];
               $fcount->distance = $request->distance[$i];
               $fcount->save();
           }
        }
         /// End Facilities  ////
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
        $facilities = Facility::where('property_id',$id)->get();
        $property = Property::findOrFail($id);
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
       
        return view('agent.property.edit_property',compact('property','propertytype','amenities','property_ami','facilities'));
    }// End Method 
     public function AgentUpdateProperty(Request $request){
        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        $property_id = $request->id;
        Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)), 
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
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id, 
            'updated_at' => Carbon::now(), 
        ]);
         $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('agent.all.property')->with($notification); 
    }// End Method 

    public function AgentUpdatePropertyFacilities(Request $request){
        $pid = $request->id;
        if ($request->facility_name == NULL) {
           return redirect()->back();
        }else{
            Facility::where('property_id',$pid)->delete();
          $facilities = Count($request->facility_name); 
      
           for ($i=0; $i < $facilities; $i++) { 
               $fcount = new Facility();
               $fcount->property_id = $pid;
               $fcount->facility_name = $request->facility_name[$i];
               $fcount->distance = $request->distance[$i];
               $fcount->save();
           } // end for 
        }
         $notification = array(
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    }// End Method 
    public function AgentDetailsProperty($id){
        $facilities = Facility::where('property_id',$id)->get();
        $property = Property::findOrFail($id);
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        
        return view('agent.property.details_property',compact('property','propertytype','amenities','property_ami','facilities'));
    }// End Method 
    public function AgentDeleteProperty($id){
        $property = Property::findOrFail($id);
        Property::findOrFail($id)->delete();
        $facilitiesData = Facility::where('property_id',$id)->get();
        foreach($facilitiesData as $item){
            $item->facility_name;
            Facility::where('property_id',$id)->delete();
        }
         $notification = array(
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    }// End Method  
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
    public function PackageHistory(){
        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id',$id)->get();
        return view('agent.package.package_history',compact('packagehistory'));
    }// End Method 


    public function AgentPackageInvoice($id){

        $packagehistory = PackagePlan::where('id',$id)->first();

        $pdf = Pdf::loadView('agent.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }// End Method 



} 