<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseBasicInfoCreateRequest;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CourseController extends Controller
{
    use FileUpload;

    function index(): View
    {
        $courses = Course::with(['instructor'])->paginate(25);
        return view('admin.course.course-module.index', compact('courses'));
    }

    /** change approve status */
    function updateApproval(Request $request, Course $course) : Response{
        $course->is_approved = $request->status;
        $course->save();

        return response(['status' => 'success', 'message' => 'Updated successfully.']);
    }


    function create(): View
    {
        $instructors = User::where('role', 'bendahara')
            ->where('approve_status', 'approved')->get();
        return view('admin.course.course-module.create', compact('instructors'));
    }


    function storeBasicInfo(CourseBasicInfoCreateRequest $request)
    {
        $thumbnailPath = $this->uploadFile($request->file('thumbnail'));
        $course = new Course();
        $course->title = $request->title;
        $course->slug = \Str::slug($request->title);
        $course->thumbnail = $thumbnailPath;
        $course->demo_video_storage = $request->demo_video_storage;
        $course->demo_video_source = $request->demo_video_source;
        $course->description = $request->description;
        $course->instructor_id = $request->instructor;
        $course->save();

        // save course id on session
        Session::put('course_create_id', $course->id);

        return response([
            'status' => 'success',
            'message' => 'Updated successfully.',
            'redirect' => route('admin.courses.edit', ['id' => $course->id, 'step' => $request->next_step])
        ]);
    }


    function edit(Request $request)
    {

        switch ($request->step) {
            case '1':
                $course = Course::findOrFail($request->id);
                return view('admin.course.course-module.edit', compact('course'));
                break;

            case '2':
                $categories = CourseCategory::where('status', 1)->get();
                $levels = CourseLevel::all();
                $languages = CourseLanguage::all();
                $course = Course::findOrFail($request->id);
                return view('admin.course.course-module.more-info', compact('categories', 'levels', 'languages', 'course'));
                break;


            case '3':
                $courseId = $request->id;
                $course = Course::findOrFail($request->id);
                $editMode = true;
                return view('admin.course.course-module.finish', compact('course', 'editMode'));
                break;
        }
    }

    function update(Request $request)
    {
        // dd($request->all());
        switch ($request->current_step) {
            case '1':
                $rules = [
                    'title' => ['required', 'max:255', 'string'],
                    'demo_video_storage' => ['nullable', 'in:youtube,vimeo,external_link,upload', 'string'],
                    'description' => ['required'],
                    'thumbnail' => ['nullable', 'image', 'max:3000'],
                    'demo_video_source' => ['nullable']
                ];

                $request->validate($rules);

                $course = Course::findOrFail($request->id);

                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $this->uploadFile($request->file('thumbnail'));
                    $this->deleteFile($course->thumbnail);
                    $course->thumbnail = $thumbnailPath;
                }

                $course->title = $request->title;
                $course->slug = \Str::slug($request->title);
                $course->demo_video_storage = $request->demo_video_storage;
                $course->demo_video_source = $request->filled('file') ? $request->file : $request->url;
                $course->description = $request->description;
                $course->save();

                // save course id on session
                Session::put('course_create_id', $course->id);

                return response([
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                    'redirect' => route('admin.courses.edit', ['id' => $course->id, 'step' => $request->next_step])
                ]);

                break;

            case '2':
                // validation
                $request->validate([
                    'category' => ['required', 'integer'],
                    'level' => ['required', 'integer'],
                    'language' => ['required', 'integer'],
                ]);

                // update course data
                $course = Course::findOrFail($request->id);
                $course->category_id = $request->category;
                $course->course_level_id = $request->level;
                $course->course_language_id = $request->language;
                $course->save();

                return response([
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                    'redirect' => route('admin.courses.edit', ['id' => $course->id, 'step' => $request->next_step])
                ]);

                break;
            case '3':
                return response([
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                    'redirect' => route('admin.courses.edit', ['id' => $request->id, 'step' => $request->next_step])
                ]);
                break;

            case '4':
                // validation
                $request->validate([
                    'message' => ['nullable', 'max:1000', 'string'],
                    'status' => ['required', 'in:active,inactive,draft']
                ]);

                // update course data
                $course = Course::findOrFail($request->id);
                $course->message_for_reviewer = $request->message;
                $course->status = $request->status;
                $course->save();
                return response([
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                    'redirect' => route('admin.courses.index')
                ]);
                break;
        }
    }
    public function destroy($id): Response
{
    try {
        // Temukan course berdasarkan ID
        $course = Course::findOrFail($id);


        // Hapus course
        $course->delete();

        // Notifikasi sukses menggunakan notyf
        notyf()->success('Course deleted successfully!');

        return response([
            'status' => 'success',
            'message' => 'Course deleted successfully.',
            'redirect' => route('admin.courses.index'),
        ], 200);
    } catch (Exception $e) {
        // Log error jika terjadi kesalahan
        logger("Course Deletion Error >> " . $e);

        // Notifikasi error menggunakan notyf
        notyf()->error('Something went wrong while deleting the course.');

        return response([
            'status' => 'error',
            'message' => 'Something went wrong!',
        ], 500);
    }
}


}
