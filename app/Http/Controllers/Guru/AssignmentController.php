<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Menampilkan daftar tugas yang dibuat oleh guru tersebut
        $assignments = Assignment::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();

        return view('guru.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        $activeYear = AcademicYear::where('is_active', true)->first();

        if (!$activeYear) {
            return redirect()->route('guru.assignments.index')->with('error', 'Tidak ada Tahun Ajaran yang aktif.');
        }

        // Ambil kelas yang diajar guru ini (logic sama dengan Materials)
        $teachingClasses = Schedule::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $activeYear->id)
            ->get()
            ->unique(function ($item) {
                return $item->classroom_id . '-' . $item->subject_id;
            });

        $types = ['Tugas Harian', 'Kuis Mingguan', 'Ulangan Harian', 'PTS', 'PAS'];

        return view('guru.assignments.create', compact('teachingClasses', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_subject' => 'required|string',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Tugas Harian,Kuis Mingguan,Ulangan Harian,PTS,PAS',
            'due_date' => 'required|date|after:now',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
        ]);

        $teacher = Auth::user()->teacher;
        $parts = explode('|', $request->classroom_subject);
        
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments/attachments', 'public');
        }

        Assignment::create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $parts[0],
            'subject_id' => $parts[1],
            'title' => $request->title,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('guru.assignments.index')->with('success', 'Tugas/Evaluasi berhasil diterbitkan.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('guru.assignments.index')->with('success', 'Tugas berhasil dihapus.');
    }
}