<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursePageController extends Controller
{
    function index(Request $request): View
    {
        // dd($request->all());
        $courses = Course::where('is_approved', 'approved')
            ->where('status', 'active')
            ->when($request->has('search') && $request->filled('search'), function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->when($request->has('category') && $request->filled('category'), function($query) use ($request) {
                if(is_array($request->category)){
                    $query->whereIn('category_id', $request->category);
                }else {
                    $query->where('category_id', $request->category);
                }
            })
            ->when($request->filled('main_category'), function($query) use ($request) {
                $query->whereHas('category', function($query) use ($request) {
                    $query->whereHas('parentCategory', function($query) use ($request){
                        $query->where('slug', $request->main_category);
                    });
                });
            })
            ->when($request->has('level') && $request->filled('level'), function($query) use ($request) {
                $query->whereIn('course_level_id', $request->level);
            })
            ->when($request->has('language') && $request->filled('language'), function($query) use ($request) {
                $query->whereIn('course_language_id', $request->language);
            })
            ->when($request->has('from') && $request->has('to') && $request->filled('from') && $request->filled('to'), function($query) use ($request) {
                $query->whereBetween('price', [$request->from, $request->to]);
            })
            ->orderBy('id', $request->filled('order') ? $request->order : 'desc')
            ->paginate(12);

        $categories = CourseCategory::where('status', 1)->whereNull('parent_id')->get();
        $levels = CourseLevel::all();
        $languages = CourseLanguage::all();
        return view('frontend.pages.course-page', compact('courses', 'categories', 'levels', 'languages'));
    }

    function show(string $slug): View
    {
        $course = Course::with('reviews')->where('slug', $slug)
            ->where('is_approved', 'approved')
            ->where('status', 'active')
            ->firstOrFail();
        $reviews = Review::where('course_id', $course->id)->where('status', 1)->paginate(10);


        return view('frontend.pages.course-details-page', compact('course', 'reviews'));
    }



function storeReview(Request $request): RedirectResponse
{
    $request->validate([
        'rating' => ['required', 'numeric'],
        'review' => ['required', 'string', 'max:1000'],
        'course' => ['required', 'integer'],
        // Tambahkan validasi name & email hanya jika user tidak login
        'name' => [auth()->check() ? 'nullable' : 'required', 'string', 'max:255'],
        'email' => [auth()->check() ? 'nullable' : 'required', 'email', 'max:255'],
    ]);

    $userId = auth()->check() ? auth()->id() : null;

    // Cek apakah sudah pernah mereview
    if ($userId) {
        $alreadyReviewed = Review::where('user_id', $userId)
            ->where('course_id', $request->course)
            ->where('status', 1)
            ->exists();

        if ($alreadyReviewed) {
            notyf()->error('You already reviewed this course!');
            return redirect()->back();
        }
    }

    $review = new Review();
    $review->course_id = $request->course;
    $review->rating = $request->rating;
    $review->review = $request->review;


    // Bedakan antara user login dan guest
    if ($userId) {
        $review->user_id = $userId;
    } else {
        $review->name = $request->name;
        $review->email = $request->email;
    }

    $review->status = 0; // atau 0 kalau harus direview admin dulu
    $review->save();

    notyf()->success('Review berhasil dikirim!');
    return redirect()->back();

}
}
