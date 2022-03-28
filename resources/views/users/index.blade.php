<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <!-- <x-slot name="footer">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('footer') }}
        </h2>
    </x-slot> -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form>
                    <div class="row">
                    <div class="col">
                        <a href="{{ route('users.create') }}" class="btn btn-sm" id="btnCreateUser"> Create a User </a>
                        </div>
                        <div class="col">
                        <div class="input-group">
                                <input type="search" class="form-control rounded sm" placeholder="Search" name="searchbox"  id="searchInput"/>
                                <button type="button" class="btn btn-outline-primary" id="btnSearch">search</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <table class="table table-striped">
                        <tr>
                            <th>ID </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>{{date('M d,Y h:i',strtotime($user->created_at))}}</td>
                            <td>{{date('M d,Y h:i',strtotime($user->updated_at))}}</td>
                            <td>
                            <a href="/users/{{$user->id}}">
                            <button type="button" class="btn btn-outline-primary btn-sm" >Edit</button></a>
                            <form method=POST action="/users/{{$user->id}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm" id="btnDelUser">Delete</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

