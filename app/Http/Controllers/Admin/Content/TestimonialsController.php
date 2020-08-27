<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class TestimonialsController
 * @package App\Http\Controllers\Admin\Content
 */
class TestimonialsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Testimonial $testimonials */
        $testimonials = Testimonial::where(null);

        if ($request->has('search')) {
            $testimonials->where(function($query) use($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('testimonial', 'like', '%'.$request->search.'%');
            });
        }

        $testimonials = $testimonials->paginate(20);

        return view('admin.content.testimonials.index', [
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::findOrFail($id);

        return view('admin.content.testimonials.show', [
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.content.testimonials.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = Testimonial::where('email', $request->testimonial['email'])
            ->where('language_id', $request->testimonial['language_id'])
            ->count();

        if ($checkExists > 0) {
            session()->flash('error', __('testimonial_with_this_email_already_created'));
            return back();
        }

        $data = $request->all('testimonial');
        $data = $data['testimonial'];

        /** @var Testimonial $reg */
        $reg = Testimonial::create($data);

        if (!$reg) {
            session()->flash('error', __('unable_to_register_review'));
            return back();
        }

        session()->flash('success', __('review_created'));
        return redirect()->route('admin.content.testimonials.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::findOrFail($id);

        $data = $request->all('testimonial');
        $data = $data['testimonial'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');

        $testimonial->update($data);

        session()->flash('success', __('review_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        session()->flash('success', __('review_deleted'));
        return redirect()->route('admin.content.testimonials.index');
    }
}
