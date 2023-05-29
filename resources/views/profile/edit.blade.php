<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex  align-content-between ">
                
                <div class=" col mr-4">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class= "col justify-center align-content-center align-items-center">
                    <div class="row">
                        <img src="{{ route('resizeShowImage', ['user' => Auth::user()]) }}" alt="" class=" justify-end" style="width: auto; height: auto;">
                    </div>
                    <div class="row ">
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div>
                                <x-input-label for="image" :value="__('Image')" />
                                <input type="file" name="image" id="image">
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <x-primary-button class="text-center">{{ __('modifier') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
