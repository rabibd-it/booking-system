<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:127',
            'mobile' => 'nullable|numeric|digits:11',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'remark' => 'nullable|string|min:5',
        ]);
        $data['status'] = 1;
        $item = Booking::create($data);
        return response()->json([
            'success' => $item->name . ' has been booking successful'
        ]);
    }

    public function checkBooking(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time'
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');
        $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        $end_time = Carbon::parse($request->end_time)->format('H:i:s');

        $checkBooking = Booking::whereDate('date', $date)->whereBetween('start_time', [$start_time, $end_time])->orWhereBetween('end_time', [$start_time, $end_time])->first();
        if ($checkBooking) {
            return response()->json([
                'message' => $checkBooking->name . ' has been already booked the meeting room for this time slot.'
                    . ' date: ' . Carbon::parse($checkBooking->date)->format('M d, Y')
                    . ', start time: ' . Carbon::parse($checkBooking->start_time)->format('h:ia')
                    . ', end time: ' . Carbon::parse($checkBooking->end_time)->format('h:ia')
                    . '. Please try another time slot'
            ]);
        }
    }

    public function show()
    {
        $bookings = Booking::paginate(10);
        return view('list', compact('bookings'));
    }
}
