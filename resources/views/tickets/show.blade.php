<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Tickets / Edit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                @if (Auth::user()->role == 'Member')
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
                    <h1 class="h2">{{ $ticket->subject }} {{ $ticket->label }}</h1>
                     <div class="btn-toolbar mb-2 mb-md-0">
                      <div class="btn-group me-2">
                         <button type="label" class="btn btn-sm btn-outline-secondary" disabled>{{$ticket->assignee->name}}</button>
                            <button type="label" class="btn btn-sm btn-outline-secondary" disabled>{{$ticket->priority}}</button>
                                <button type="label" class="btn btn-sm btn-outline-secondary" disabled>{{$ticket->status}}</button>
                            </div>
                         </div>
                    </div>
                    @endif

                    @if (Auth::user()->role == 'Admin')
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
                    <h1 class="h2">{{ $ticket->subject }} {{ $ticket->label }}</h1>
                     <div class="btn-toolbar mb-2 mb-md-0">
                      <div class="btn-group me-2">
                         <button type="label" class="btn btn-sm btn-outline-secondary" disabled>{{$ticket->submitter->name}}</button>
                            <button type="label" class="btn btn-sm btn-outline-secondary" disabled>{{ date('M d, Y h:i',strtotime($ticket->created_at)) }}</button>
                            </div>
                         </div>
                    </div>
                    @endif

                <form method="POST" action="/my/tickets/{{$ticket->id}}">
                @method('PUT')
                @csrf
                <div>
                <label for="Name" class="form-label">Name</label>

                 <input type="text" class="form-control" id="name" name="name" value="{{$ticket->name }}">
            </div>
                <div>
                 <label for="Subject" class="form-label">Subject</label>

                 <input type="text" class="form-control" id="subject" name="subject" value="{{$ticket->subject }}">
            </div>
            <div>
                <label for="Label" class="form-label">Label</label>

                <input type="text" class="form-control" id="label" name="label" value="{{$ticket->label }}">
            </div>
            @if (Auth::user()->role == 'Admin')
            <div>
                <label for="Assignee" class="form-label">Assignee</label>
                <select class= "form-select"id="assignee_id" name="assignee_id" value="{{$ticket->assignee_id }}">
                @foreach ($users as $user)
                    <option value="{{$user->id}}" {{($ticket->assignee_id==$user->id) ?"selected" :""}}>{{$user->name}}</option>
                @endforeach
                </select>
            </div>
            <div>
                <label for="Priority" class="form-label">Priority</label>
                <select  class= "form-select" id="priority" name="priority">
                    <option value="High" {{($ticket->priority=='High') ?"selected" :""}}>High</option>
                    <option value="Mid" {{($ticket->priority=='Mid') ?"selected" :""}}>Mid</option>
                    <option value="Low" {{($ticket->priority=='Low') ?"selected" :""}}>Low</option>
                </select>
            </div>
                 <div>
                <label for="Status" class="form-label">Status</label>
                <select class= "form-select" id="status" name="status"value="{{$ticket->status }}">
                    <option value="Resolved"  {{($ticket->status=='Resolved') ?"selected" :""}}>Resolved</option>
                    <option value="On-Going" {{($ticket->status=='On-Going') ?"selected" :""}}>On-going</option>
                    <option value="Rejected" {{($ticket->status=='Rejected') ?"selected" :""}}>Rejected</option>
                </select>
            </div>
            @endif
            <br>

            <input type="hidden" id="id" name="id" value="{{$ticket->id}}">

            <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-sm" id="btnUpdate">UPDATE TICKET</button>
            </div>
            </form>


                <form method="POST" action="/comments">
                @csrf
                <div>
                <label for="Comment" class="form-label">Comment</label>
                 <textarea class="form-control" id="messages" name="messages"></textarea>
            </div>
            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
            <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-secondary btn-sm" id="btnDelComment">Comment</button>
                </form>
                </div>



                @foreach($ticket->comments as $comment)
                <div class="card shadow-sm" id="commentSection">
                <div class="row align-items-md">
                <div class="col">
                   <b>{{$comment->user->name}}</b>
                   <small id="dateTime">  {{ date('M d, Y h:i',strtotime($comment->created_at)) }}</small>
                   <hr>
                </div>
                    <div class="w-100"></div>
                        <div class="col-9">
                            {{$comment->messages}}
                        </div>
                        <div class="col">
                        <form method="POST" action="/comments">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm" id="btnDelComment">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <br>
            @endforeach

            </div>
        </div>
    </div>

</x-app-layout>



