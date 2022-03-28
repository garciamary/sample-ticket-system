<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form>
                    <div class="h1">My Ticket</div>
                    <br>
                    <div class="row">
                    <div class="col">
                            <a href="{{ route('my.tickets.create') }}" class="btn btn-sm" id="btnSubmit"> Submit a Ticket </a>
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

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($tickets as $ticket)
                    <div class="col" >
                        <div class="card shadow-sm">
                            <div class="card-header">
                            <b>{{ $ticket->name }}</b>
                            <span class="badge rounded-pill" id="lowMidHigh">{{ $ticket->priority }}</span>


                            <a href="my/tickets/{{$ticket->id}}">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnEdit">Edit</button></a>
                            </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->subject }} {{ $ticket->label }}</h5>
                            </div>
                                <div class="card-footer text-muted bg-light">
                                <form method=POST action="my/tickets/{{$ticket->id}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm" id="btnDel">Delete</button>
                                 </form>
                                {{ $ticket->status }}
                                <p>{{ date('M d, Y h:i',strtotime($ticket->created_at)) }}</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






