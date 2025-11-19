<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('faqs.index');
    }

    public function create()
    {
        return view('faqs.create');
    }


    public function edit(string $id)
    {
        //
        $faq = Faq::find($id);
        return view('faqs.edit', compact('faq'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'reponse' => 'required'
        ]);

        $data = [
            'question' => $request->input('question'),
            'reponse' => $request->input('reponse'),
            'priority' => $request->input('priority'),
            'creator_id' => Auth::id()
        ];


        if (Faq::create($data)) {
            return redirect()->route('faqs.index')
                ->withMessage('Question enregistrée avec succès.');
        }

        return back()->withMessage('Une erreur est survenue.');
    }


    public function update(Request $request, string $id)
    {

        $request->validate([
            'question' => 'required',
            'reponse' => 'required'
        ]);

        $faq = Faq::find($id);

        if ($faq->update(['question' => request('question'), 'reponse' => request('reponse'), 'priority' => request('priority')])) {
            return redirect()->route('faqs.index')
                ->withMessage('Question modifiée avec succès.');
        }
        return back()->withMessage('Une erreur est survenue.');
    }

    public function destroy(string $id)
    {
        //
        $question = Faq::findOrFail($id);
        $question->delete();

        return redirect()->route('faqs.index')
            ->withMessage('Question supprimée avec succès.');
    }


}
