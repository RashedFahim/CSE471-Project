<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenities;
use Illuminate\Support\Facades\Route;


class PropertyTypeController extends Controller
{
    public function AllType(){

        $types = PropertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));

    } // End Method 

    // For get
    public function NewType()
    {
        $types = PropertyType::all(); // Fetch all records
        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }

    // For post
    public function SaveType(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ]);

        $type = PropertyType::create([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Property Type created successfully',
            'data' => $type
        ]);
    }


    public function AddType(){

        return view('backend.type.add_type');

    } //end method


    public function StoreType(Request $request){

        //validation
        $request->validate([
            'type_name'=>'required|unique:property_types',
            'type_icon'=> 'required'

        ]);

        PropertyType::insert([

            'type_name'=> $request->type_name,
            'type_icon'=> $request->type_icon,
        ]);

          $notification=array(
            'message'=>'Property Type Create Successfully',
            'alert-type'=>'success'
            
          );
          return redirect()->route('all.type')->with($notification);

    } //end method
        
         
    public function EditType($id){

        $types = PropertyType::findOrFail($id);
        return view('backend.type.edit_type',compact('types'));

    }// End Method 

     public function UpdateType(Request $request){

        $pid = $request->id;
     
        PropertyType::findOrFail($pid)->update([ 

            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon, 
        ]);

          $notification = array(
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);

    }// End Method 


    public function DeleteType($id){

        PropertyType::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method 


     ///////////// Amenitites All Method //////////////


    public function AllAmenitie(){

        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities',compact('amenities'));

    } // End Method 

    public function AddAmenitie(){
        return view('backend.amenities.add_amenities');
    }// End Method   
    

    public function StoreAmenitie(Request $request){ 
        Amenities::insert([ 

            'amenitis_name' => $request->amenitis_name, 
        ]);

          $notification = array(
            'message' => 'Amenities Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);

    }// End Method 


    public function EditAmenitie($id){

        $amenities = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenities',compact('amenities'));

    }// End Method 


    public function UpdateAmenitie(Request $request){ 

        $ame_id = $request->id;

        Amenities::findOrFail($ame_id)->update([ 

            'amenitis_name' => $request->amenitis_name, 
        ]);

          $notification = array(
            'message' => 'Amenities Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);

    }// End Method 


    public function DeleteAmenitie($id){

        Amenities::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenities Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method

    

}


    
    