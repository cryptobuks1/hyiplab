<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class NewsController
 * @package App\Http\Controllers\Admin\Settings
 */
class NewsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var News $news */
        $news = News::where(null);

        if ($request->has('search')) {
            $news->where(function($query) use($request) {
                $query->where('subject', 'like', '%'.$request->search.'%')
                    ->orWhere('content', 'like', '%'.$request->search.'%');
            });
        }

        $news = $news->paginate(20);

        return view('admin.content.news.index', [
            'news' => $news,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var News $news */
        $news = News::findOrFail($id);

        return view('admin.content.news.show', [
            'news' => $news,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.content.news.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = News::where('subject', $request->news['subject'])->count();

        if ($checkExists > 0) {
            session()->flash('error', __('news_with_this_title_already_registered'));
            return back();
        }

        $data = $request->all('news');
        $data = $data['news'];

        /** @var News $reg */
        $reg = News::create($data);

        if (!$reg) {
            session()->flash('error', __('unable_to_register_news'));
            return back();
        }

        session()->flash('success', __('news_created'));
        return redirect()->route('admin.content.news.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var News $news */
        $news = News::findOrFail($id);

        $data = $request->all('news');
        $data = $data['news'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');

        $news->update($data);

        session()->flash('success', __('news_updated'));
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
        /** @var News $news */
        $news = News::findOrFail($id);
        $news->delete();

        session()->flash('success', __('news_deleted'));
        return redirect()->route('admin.content.news.index');
    }
}
