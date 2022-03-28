<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Users / Create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div>
                <label for="Name" class="form-label">Name</label>

                 <input type="text" class="form-control" id="name" name="name">
            </div>
                <div>
                 <label for="Email" class="form-label">Email</label>

                 <input type="email" class="form-control" id="email" name="email">
            </div>
            <div>
                <label for="Name" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                     <option value="Admin">Admin</option>
                     <option value="Member">Member</option>
                </select>
            </div>
                 <div>

                <label for="Password" class="form-label">Password</label>

                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-3">
                    {{ __('Create') }}
                </x-button>
            </div>
                     </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

