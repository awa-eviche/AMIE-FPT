<x-app-layout>
  <div class="py-12">
    <div class="max-full mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          {{ __("Menu") }}
        </div>
      </div>
      <div class="flex flex-wrap justify-center">
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="{{route('users.index')}}">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-users"></i></span>
              <h3 class="text-xl font-semibold">Utilisateurs</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="{{route('roles.index')}}">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-puzzle-piece"></i></span>
              <h3 class="text-xl font-semibold">Roles</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="{{route('permissions.index')}}">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-lock"></i></span>
              <h3 class="text-xl font-semibold">Permissions</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="{{route('users.logs')}}">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-eye"></i></span>
              <h3 class="text-xl font-semibold">Historiques</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>