<div class="mx-auto max-w-screen-lg">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="p-4 flex flex-col">
  <div class="text-first-orange text-2xl font-bold pb-4">CONTACTS</div>
  <div class="text-first-orange text-base">
  APIX, Promotion des Investissements
  et Grands Travaux Sénégal
  </div>
  <div class="text-first-orange text-base py-4">
    52 - 54 Rue Mohamed V
    BP 430 CP 18524 Dakar RP Sénégal
  </div>
  <div class="text-first-orange text-base py-4">
  Tél. : (+221) 33 849 05 55
  </div>
  <div class="text-first-orange text-base py-4">
  Fax : (+221) 33 823 94 89
  </div>
  <div class="text-first-orange text-base py-4 font-semibold">
  infos@apix.sn
  </div>
  <div class="text-first-orange text-base py-4">
  Suivez-nous sur les <br>
réseaux sociaux!
 </div>
 <div class="text-first-orange">
 <span class="px-2"><i class="fab fa-facebook fa-2x"></i></span>
 <span class="px-2"><i class="fab fa-twitter  fa-2x"></i></span>
 <span class="px-2"><i class="fab fa-linkedin fa-2x"></i></span>
 <span class="px-2"><i class="fab fa-instagram  fa-2x"></i></span>
 <span class="px-2"><i class="fab fa-youtube  fa-2x"></i></span>
 </div>
    </div>
    <div class="p-4 flex flex-col">
        <div class="pt-12 text-first-orange text-base">
        Contactez- nous directement en complétant <br> ce formulaire.
        </div>
        <div>
        <form method="POST" action="#" class="max-w-2xl mt-2">
    @csrf

    <div class="mb-4 w-full">

        <div class="relative h-11 w-full">
          <input
            class="input_contact peer placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full"
            placeholder=" " type="text" name="name" id="name"
          />
          <label class="peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-first-orange peer-focus:after:scale-x-100 peer-focus:after:border-first-orange peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 label_input_contact">
            Nom complet
          </label>
        </div>
      </div>
    {{-- <div class="mb-4">
        <label for="name" class="block text-first-orange">Nom complet</label>
        <input type="text" name="name" id="name" class="w-full bg-white p-2 rounded borderBottom">
    </div> --}}

    <div class="mb-4 w-full">

        <div class="relative h-11 w-full">
          <input
            class="input_contact peer placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full"
            placeholder=" " type="email" name="email" id="email"
          />
          <label class="peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-first-orange peer-focus:after:scale-x-100 peer-focus:after:border-first-orange peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 label_input_contact">
            Email
          </label>
        </div>
      </div>

    {{-- <div class="mb-4">
        <label for="email" class="block text-first-orange">Email</label>
        <input type="email" name="email" id="email" class="w-full bg-white p-2 rounded borderBottom">
    </div> --}}

    {{-- <div class="mb-4 w-full">

        <div class="relative h-11 w-full">
            <textarea name="message" id="message" rows="4" class="w-full bg-white p-2 rounded borderBottom"></textarea>

          <label class="peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-first-orange peer-focus:after:scale-x-100 peer-focus:after:border-first-orange peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 label_input_contact">
            Message
          </label>
        </div>
      </div> --}}

    {{-- <div class="mb-4">
        <label for="message" class="block text-first-orange">Message</label>
        <textarea name="message" id="message" rows="4" class="w-full bg-white p-2 rounded borderBottom"></textarea>
    </div> --}}

    <div class="w-full">
        <div class="relative w-full min-w-[200px]">
          <textarea
            class="input_contact peer placeholder-shown:border-blue-gray-200 disabled:border-0 disabled:bg-blue-gray-50 w-full"
            placeholder=" "
            name="message" id="message" rows="4"
          ></textarea>
          <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-first-orange peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:border-first-orange peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:border-first-orange peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
            Message
          </label>
        </div>
    </div>



    <div class="mt-4">
        <button type="submit" class="w-1/3 border-solid border-2 border-first-orange bg-white text-first-orange px-2 py-3 hover:text-white  hover:bg-first-orange font-black">ENVOYER</button>
    </div>
</form>

        </div>
    </div>
  </div>
</div>
