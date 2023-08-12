@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Booking List') }}</div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td>{{ $bookings->firstItem() + $loop->index }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->mobile }}</td>
                                        <td>{{ $booking->date->format('M d, F') }}</td>
                                        <td>{{ Carbon\Carbon::parse($booking->start_time)->format('h:ia') }}</td>
                                        <td>{{ Carbon\Carbon::parse($booking->end_time)->format('h:ia') }}</td>
                                        <td>
                                            @if ($booking->status)
                                                <div class="badge bg-success">Confirmed</div>
                                            @else
                                                <div class="badge bg-danger">Not Confirmed</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
