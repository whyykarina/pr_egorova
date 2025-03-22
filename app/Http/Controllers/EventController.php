<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date', Carbon::now()->toDateString()); // Default to today
        $view = $request->query('view', 'month'); // Default to month view

        $dateCarbon = Carbon::parse($date);

        // Generate URLs for previous and next based on the current view
        if ($view == 'day') {
            $prevDate = $dateCarbon->copy()->subDay()->toDateString();
            $nextDate = $dateCarbon->copy()->addDay()->toDateString();
        } elseif ($view == 'week') {
            $prevDate = $dateCarbon->copy()->subWeek()->toDateString();
            $nextDate = $dateCarbon->copy()->addWeek()->toDateString();
        } else { // month
            $prevDate = $dateCarbon->copy()->subMonth()->toDateString();
            $nextDate = $dateCarbon->copy()->addMonth()->toDateString();
        }

        $events = $this->getEventsForView($user, $date, $view, $request); // Pass the request

        $categories = Category::where('user_id', $user->id)->get();

        return view('events.index', compact('events', 'categories', 'date', 'view', 'prevDate', 'nextDate'));
    }

    private function getEventsForView($user, $dateString, $view)
    {
        $date = Carbon::parse($dateString);

        $query = Event::where('user_id', $user->id);

        switch ($view) {
            case 'day':
                $query->whereDate('start_time', $date);
                break;
            case 'week':
                $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY);
                $endOfWeek = $date->copy()->endOfWeek(Carbon::SUNDAY);
                $query->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
                break;
            case 'month':
            default:
                $query->whereMonth('start_time', $date->month)
                      ->whereYear('start_time', $date->year);
                break;
        }

        return $query->orderBy('start_time')->get();
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'recurring_type' => 'nullable|in:none,daily,weekly,monthly',
            'recurring_end_date' => 'nullable|date|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event = new Event($request->all());
        $event->user_id = Auth::id();
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $this->authorize('update', $event); // Ensure user owns the event
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $categories = Category::where('user_id', Auth::id())->get();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event); // Check authorization

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'recurring_type' => 'nullable|in:none,daily,weekly,monthly',
            'recurring_end_date' => 'nullable|date|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event); // Check authorization

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}