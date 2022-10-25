<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Timeline;
use App\Services\TimetableService;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class TimetableController extends Controller
{
    public function index(Request $request) {
        $days = Day::with(['creator', 'updater', 'timelines'])->orderBy('date')->get();

        return view('service.admin.timetable.index', compact('days'));
    }

    public function create(Request $request) {
        return view('service.admin.timetable.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'date' => 'required|date|unique:timetable_days',
            'name' => 'required',
            'place' => 'required'
        ]);

        $day = Day::create($validated);

        $timelines = TimetableService::getTimelinesFromPostData($request->post());
        list($timelines, $errors) = TimetableService::validateTimelines($timelines);
        if (empty($timelines) && !empty($errors)) {
            return redirect()->route('admin.timetable.edit', ['id' => $day->id])
                ->withErrors($errors);
        }

        foreach ($timelines as $timeline) {
            Timeline::create($timeline + ['day_id' => $day->id]);
        }
        $request->session()->flash('status', 'Успешно создано');

        return redirect(route('admin.timetable.index'))->withErrors($errors);
    }

    public function edit(Request $request, $id) {
        $day = Day::with('timelines')->findOrFail($id);

        return view('service.admin.timetable.edit', compact('day'));
    }

    public function update(Request $request, $id) {
        $day = Day::with('timelines')->findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date|unique:timetable_days,date,'.$day->id,
            'name' => 'required',
            'place' => 'required'
        ]);

        $day->update($validated);

        $timelines = TimetableService::getTimelinesFromPostData($request->post());
        list($timelines, $errors) = TimetableService::validateTimelines($timelines);
        if (empty($timelines) && !empty($errors)) {
            return redirect()->route('admin.timetable.edit', ['id' => $day->id])
                ->withErrors($errors);
        }

        $day->timelines->each->delete();

        foreach ($timelines as $timeline) {
            Timeline::create($timeline + ['day_id' => $day->id]);
        }
        $request->session()->flash('status', 'Успешно обновлено');

        return redirect(route('admin.timetable.index'))->withErrors($errors);
    }

    public function delete(Request $request, $id) {
        Day::findOrFail($id)->delete();
        $request->session()->flash('status', 'Успешно удалено');

        return redirect()->route('admin.timetable.index');
    }

    public function toggle(Request $request) {
        if (cache('timetable')) {
            cache()->put('timetable', false, now()->addMonth());
            Audit::create([
                'user_type' => 'App\Models\User',
                'user_id' => auth()->id(),
                'event' => 'off',
                'auditable_type' => 'App\Models\Timetable',
                'auditable_id' => 1,
                'old_values' => ['timetable' => 'on'],
                'new_values' => ['timetable' => 'off'],
                'url' => request()->getRequestUri(),
            ]);
            $request->session()->flash('status', 'Расписание больше не отображается');
        }
        else {
            cache()->put('timetable', true, now()->addMonth());
            Audit::create([
                'user_type' => 'App\Models\User',
                'user_id' => auth()->id(),
                'event' => 'on',
                'auditable_type' => 'App\Models\Timetable',
                'auditable_id' => 1,
                'old_values' => ['timetable' => 'off'],
                'new_values' => ['timetable' => 'on'],
                'url' => request()->getRequestUri(),
            ]);
            $request->session()->flash('status', 'Расписание теперь отображается');
        }

        return redirect()->route('admin.timetable.index');
    }
}
