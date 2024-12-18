<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;

class PropertyTypeController extends Controller
{
    public function AllType(){
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));
    } // End Method 

    public function AddType(){
        return view('backend.type.add_type');
    } //end method

    public function StoreType(Request $request){
        //validation
        $request->validate([
            'type_name'=>'required|unique:property_types',
            'type_icon'=> 'required'
        ]);
        propertyType::insert([
            'type_name'=> $request->type_name,
            'type_icon'=> $request->type_icon,


             
        ]);
          $notification=array(
            'message'=> 'Property Type create successfully',
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




}
