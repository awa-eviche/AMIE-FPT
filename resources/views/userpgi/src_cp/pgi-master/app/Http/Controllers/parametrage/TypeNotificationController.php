<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\TypeNotification;
use Illuminate\Http\Request;

class TypeNotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_permission');
        $this->middleware(['role:superadmin|admin']);
    }
    
    public function index()
    {
        $typeNotifications = TypeNotification::all();
        return view('parametrage.type_notification.index', compact('typeNotifications'));
    }

    public function create()
    {
        return view('parametrage.type_notification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'action' => 'required|string|max:191',
            'message' => 'required|string|max:191',
        ]);

        TypeNotification::create([
            'action' => $request->action,
            'message' => $request->message,
        ]);

        return redirect()->route('type_notification.index')
            ->with('success', 'Type de notification créé avec succès.');
    }

    public function edit(TypeNotification $typeNotification)
    {
        return view('parametrage.type_notification.edit', compact('typeNotification'));
    }

    public function show($id)
    {
        $typeNotification = TypeNotification::find($id);
        return view('parametrage.type_notification.show', compact('typeNotification'));
    }

    public function update(Request $request, TypeNotification $typeNotification)
    {
        $request->validate([
            'action' => 'required|string|max:191',
            'message' => 'required|string|max:191',
        ]);

        $typeNotification->update([
            'action' => $request->action,
            'message' => $request->message,
        ]);

        return redirect()->route('type_notification.index')
            ->with('success', 'Type de notification mis à jour avec succès.');
    }

    public function destroy(TypeNotification $typeNotification)
    {
        $typeNotification->delete();

        return redirect()->route('type_notification.index')
            ->with('success', 'Type de notification supprimé avec succès.');
    }
}
