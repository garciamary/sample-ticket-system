<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Tickets / Create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="./">
                @csrf
                <div>
                <label for="Name" class="form-label">Name</label>

                 <input type="text" class="form-control" id="name" name="name">
            </div>
                <div>
                 <label for="Subject" class="form-label">Subject</label>

                 <input type="text" class="form-control" id="subject" name="subject">
            </div>
            <div>
                <label for="Label" class="form-label">Label</label>

                <input type="text" class="form-control" id="label" name="label">
            </div>
            <div>
                <label for="Assignee" class="form-label">Assignee</label>
                <select class="form-select" id="assignee_id" name="assignee_id">
                <option selected value="">Select assignee</option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
                </select>
            </div>
            <div>
                <label for="Priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="High">High</option>
                    <option value="Mid">Mid</option>
                    <option value="Low">Low</option>
                </select>
            </div>
                 <div>
                <label for="Status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="Resolved">Resolved</option>
                    <option value="On-going">On-going</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Create Ticket') }}
                </x-button>
            </div>
                     </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


