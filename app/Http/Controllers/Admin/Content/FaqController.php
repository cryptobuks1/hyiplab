<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class FaqController
 * @package App\Http\Controllers\Admin\Content
 */
class FaqController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Faq $faq */
        $faq = Faq::where(null);

        if ($request->has('search')) {
            $faq->where(function($query) use($request) {
                $query->where('question', 'like', '%'.$request->search.'%')
                    ->orWhere('answer', 'like', '%'.$request->search.'%');
            });
        }

        $faq = $faq->paginate(20);

        return view('admin.content.faq.index', [
            'faq' => $faq,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Faq $faq */
        $faq = Faq::findOrFail($id);

        return view('admin.content.faq.show', [
            'faq' => $faq,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.content.faq.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = Faq::where('question', $request->faq['question'])->count();

        if ($checkExists > 0) {
            session()->flash('error', __('faq_with_this_question_already_registered'));
            return back();
        }

        $data = $request->all('faq');
        $data = $data['faq'];

        /** @var Faq $reg */
        $reg = Faq::create($data);

        if (!$reg) {
            session()->flash('error', __('unable_to_register_faq'));
            return back();
        }

        session()->flash('success', __('faq_created'));
        return redirect()->route('admin.content.faq.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Faq $faq */
        $faq = Faq::findOrFail($id);

        $data = $request->all('faq');
        $data = $data['faq'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');

        $faq->update($data);

        session()->flash('success', __('faq_updated_successfully'));
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
        /** @var Faq $faq */
        $faq = Faq::findOrFail($id);
        $faq->delete();

        session()->flash('success', __('faq_deleted'));
        return redirect()->route('admin.content.faq.index');
    }
}
