<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Member;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('member')->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    public function create(Member $member)
    {
        //$members = Member::all();
        return view('contacts.create', compact('member'));

    }

    public function store(Request $request, Member $member)
    {
         $validated = $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'nullable|string|max:100',
            'relationship'=> 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:150',
            'is_primary'  => 'nullable|boolean',
        ]);

        $validated['member_id']  = $member->id;
        $validated['created_by'] = auth()->id();

        Contact::create($validated);

   //     return redirect()->route('members.show', $member->id)
     return redirect()->route('members.show', ['member' => $member->id])

                         ->with('success', 'Contacto agregado correctamente.');
   

    }


public function edit(Member $member, Contact $contact)
{
    // 🔒 Seguridad opcional: verificar que el contacto pertenece al miembro
   // if ($contact->member_id !== $member->id) {
     //   abort(403, 'No autorizado.');
    //}

    return view('contacts.edit', compact('member', 'contact'));
}

    
      public function update(Request $request, Member $member, Contact $contact)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'nullable|string|max:100',
            'relationship'=> 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:150',
            'is_primary'  => 'nullable|boolean',
        ]);

        $validated['updated_by'] = auth()->id();

        $contact->update($validated);

//        return redirect()->route('members.show', $member->id)
        return redirect()->route('members.show', ['member' => $member->id])
                         ->with('success', 'Contacto actualizado correctamente.');

                         



    }

  public function destroy(Member $member, Contact $contact)
    {
        $contact->delete();

//        return redirect()->route('members.show', $member->id)
  return redirect()->route('members.show', ['member' => $member->id])
                         ->with('success', 'Contacto eliminado correctamente.');
    }

}
