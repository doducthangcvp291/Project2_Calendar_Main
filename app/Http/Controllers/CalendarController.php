<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Calendar;
use App\Models\TestEvent;
use Illuminate\Http\Request;
use App\Http\Resources\CalendarResource;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user  = auth()->user();
        return CalendarResource::collection(Calendar::where('user_id', $user->id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user  = auth()->user();
        //$new_calendar = Calendar::create(array_merge($request->all(),['user_id' => $user->id]));
        $new_test_event = TestEvent::create((array_merge($request->all(),['user_id' => $user->id])));
        return response()->json([
            // 'data' => new CalendarResource($new_calendar),
            'test_event_create_done' => $new_test_event,
            'message' => 'Successfully added new event!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        return response($calendar, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        $calendar->update($request->all());
        return response()->json([
            'data' => new CalendarResource($calendar),
            'message' => 'Successfully updated event!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Calendar::destroy($request->id);
        return response('Event removed successfully!', Response::HTTP_NO_CONTENT);
    }
}
