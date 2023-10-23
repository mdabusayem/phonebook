<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;
use DataTables;

class PhoneBookController extends Controller
{
   // public function index()
    //{
       // $contacts = Contact::with('phoneNumbers')->get();
       // return view('contacts.index', compact('contacts'));
    //}
    public function index(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Contact::with('phoneNumbers')->latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('number', function($row){
                        $b =[] ;
                           foreach($row->phoneNumbers as $numbers){
                            $b[]=$numbers->number.'('.$numbers->operator.')';
                           }
                           
    
                        return $b;
                    })
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="/contacts/'.$row->id.'/edit"  data-toggle="tooltip"   data-original-title="Edit" class="edit btn btn-primary btn-sm editContact">Edit</a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteContact">Delete</a>';
 
                         return $btn;
                 })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('contacts.index');
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(ContactRequest $request)
    {
        /*$request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_numbers' => 'array|required',
            'phone_numbers.*' => 'regex:/^01[0-9]{9}$/',
            'phone_operators' => 'array|required',
        ]);*/

        $contact = Contact::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ]);
        //dd($contact->id);

        foreach ($request->input('phone_numbers') as $key => $phoneNumber) {
            PhoneNumber::create([
                'contact_id' => $contact->id,
                'number' => $phoneNumber,
                'operator' => $request->input('phone_operators')[$key],
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully');
    }

    public function edit($id)
    {
        $contact = Contact::with('phoneNumbers')->findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_numbers' => 'array|required',
            'phone_numbers.*' => 'regex:/^01[0-9]{9}$/',
            'phone_operators' => 'array|required',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ]);

       
        $contact->phoneNumbers()->delete();

        foreach ($request->input('phone_numbers') as $key => $phoneNumber) {
            PhoneNumber::create([
                'contact_id' => $contact->id,
                'number' => $phoneNumber,
                'operator' => $request->input('phone_operators')[$key],
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
    }

    public function destroy($id)
    {
        //dd('yes');
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
    }
}
