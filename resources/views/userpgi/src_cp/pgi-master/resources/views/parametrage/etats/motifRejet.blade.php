@extends('layouts.v1.default')

@section('content')
    {!! Form::model(NULL, ['method' =>'PUT', 'route' => ['demande.rejet', $id], 'role' => 'form',
    'class' => 'apix-form', 'files' => 'true']) !!}
    @php $inputClass = "bg-gray-300 border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 " @endphp

    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <!--
    Background backdrop, show/hide based on modal state.

    Entering: "ease-out duration-300"
      From: "opacity-0"
      To: "opacity-100"
    Leaving: "ease-in duration-200"
      From: "opacity-100"
      To: "opacity-0"
  -->
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
      <div class="bg-white content-center justify-center overflow-hidden shadow-lg sm:rounded-lg max-w-lg h-full ">
        <div class="p-8 text-gray-900">
            <div class="sm:container sm:mx-auto">
                <h6 class="text-first-orange text-2xl text-center" ><b>Motiver votre décision </b> </h6>
                </br>
                <div class="sm:container sm:mx-auto">
                    <div class="grid md:gap-3 pt-2">
                        <div class="relative  w-full mb-3 ">
                            {!! Form::textarea('decision', null, ['id' => 'decision', 'class' => $inputClass, 'required' => '', 'placeholder'=>'Saisissez ici pour motivier votre décision !']) !!}
                        </div>

                    </div>
                    <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                        <div class="relative z-0 w-full mb-3 group">
                            <button wire:click="rejet"  class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
                                Enregistrer
                            </button>
                            <a href="{{ route('users.index') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                                Annuler </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      </div>
    </div>
  </div>
</div>

    @section('stylesAdditionnels')
    @parent
    {{--@include('layouts.v1.partials.select2._style')--}}
    @endsection

    @section('scriptsAdditionnels')
    @parent
    @include('layouts.v1.partials.select2._script')
    @include('layouts.v1.partials.parsley._script')
    @endsection
    {!! Form::close() !!}
@endsection
